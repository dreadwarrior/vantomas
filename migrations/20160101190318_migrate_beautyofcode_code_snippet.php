<?php

use Phinx\Migration\AbstractMigration;
use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\Extbase\Service\FlexFormService;

class MigrateBeautyofcodeCodeSnippet extends AbstractMigration
{

    /**
     * Up.
     *
     * @return void
     */
    public function up()
    {
        $bocPlugins = $this->query("SELECT uid, pi_flexform from tt_content WHERE CType = 'list' AND list_type = 'beautyofcode_contentrenderer'");

        $flexformService = new FlexFormService();

        foreach ($bocPlugins as $bocPlugin) {
            $flexformData = $flexformService->convertFlexFormContentToArray($bocPlugin['pi_flexform']);

            $subheader = $flexformData['cLabel'];
            $bodytext = $flexformData['cCode'];

            $brush = $flexformData['cLang'];
            $highlight = $flexformData['cHighlight'];
            $collapse = $flexformData['cCollapse'];
            $gutter = $flexformData['cGutter'];

            $configuration = [];

            if (!empty($brush)) {
                $configuration['brush'] = (string) $brush;
            }
            if (!empty($highlight)) {
                $configuration['highlight'] = (string) $highlight;
            }
            if (!empty($collapse) && 'auto' !== $collapse) {
                $configuration['collapse'] = (bool) $collapse;
            }
            if (!empty($gutter) && 'auto' !== $gutter) {
                $configuration['gutter'] = (bool) $gutter;
            }

            $rowDescription = Yaml::dump($configuration);

            $data = [
                $subheader,
                $bodytext,
                $rowDescription,
            ];

            $stmt = $this->getAdapter()->getConnection()->prepare(
                "UPDATE
                   tt_content
                 SET
                   CType = 'vantomas_codesnippet',
                   list_type = '',
                   pi_flexform = NULL,
                   subheader = ?,
                   bodytext = ?,
                   rowDescription = ?
                 WHERE
                   uid = " . (int) $bocPlugin['uid']
            );

            $stmt->execute($data);
        }
    }
}
