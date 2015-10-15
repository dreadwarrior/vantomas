<?php

use Phinx\Migration\AbstractMigration;

class TransferHeaderLayoutFromContentOptions extends AbstractMigration
{
    /**
     * Transfers the header_layout from serialized fluidcontent_core content_options flexform field
     *
     * @return void
     */
    public function up()
    {
        $rows = $this->query("SELECT uid, header_layout, content_options FROM tt_content WHERE content_options <> '' AND content_options IS NOT NULL");
        foreach ($rows as $row) {
            $xml = new \SimpleXMLElement($row['content_options']);

            $headerTypeSettings = $xml->xpath(
                "//T3FlexForms/*/sheet[@index='header']/*/field[@index='settings.header.type']/value/text()"
            );

            if (empty($headerTypeSettings)) {
                continue;
            }

            /* @var $headerType \SimpleXMLElement */
            $headerType = array_shift($headerTypeSettings);
            $headerLayout = (string) $headerType;

            if (!is_numeric($headerLayout)) {
                continue;
            }

            $this->execute("UPDATE tt_content SET header_layout = " . $headerLayout . " WHERE uid = " . $row['uid']);
        }

    }
}
