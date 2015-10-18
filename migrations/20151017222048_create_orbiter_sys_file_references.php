<?php

use Phinx\Migration\AbstractMigration;

class CreateOrbiterSysFileReferences extends AbstractMigration
{
    /**
     * Creates sys_file_references for the orbiter CEs
     *
     * @return void
     */
    public function up()
    {
        $rows = $this->query(
            "SELECT uid, pi_flexform FROM tt_content WHERE CType = 'vantomas_orbiter' AND pi_flexform <> '' AND pi_flexform IS NOT NULL"
        );

        foreach ($rows as $row) {
            $contentElementUid = $row['uid'];

            $xml = new \SimpleXMLElement($row['pi_flexform']);

            $images = $xml->xpath(
                "//T3FlexForms//sheet[@index='options']//field[@index='images']//section/itemType[@index='image']/el"
            );

            $nbOfImages = count($images);

            if ($nbOfImages !== 0) {
                $this->createSysFileReferences($images, $contentElementUid);
            }

            $this->execute(
                sprintf(
                    "UPDATE tt_content SET image = %d, pi_flexform = NULL WHERE uid = %d",
                    $nbOfImages,
                    $contentElementUid
                )
            );
        }
    }

    /**
     * @param \SimpleXMLElement[] $images
     * @param int $contentElementUid
     */
    private function createSysFileReferences(array $images, $contentElementUid) {
        foreach ($images as $image) {
            $srcs = $image->xpath("./field[@index='src']/value/text()");
            $descriptions = $image->xpath("./field[@index='caption']/value/text()");

            $src = (string) array_shift($srcs);
            $description = (string) array_shift($descriptions);

            $sysFiles = $this->query(
                sprintf(
                    "SELECT uid FROM sys_file WHERE storage = 1 AND CONCAT('fileadmin', identifier) = '%s'",
                    $src
                )
            );

            if (!($sysFile = $sysFiles->fetch())) {
                continue;
            }

            $this->execute(
                sprintf(
                    "INSERT INTO sys_file_reference (
                      tstamp, crdate, uid_local, uid_foreign, tablenames, fieldname, table_local, description
                    ) VALUES (
                      UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), %d, %d, 'tt_content', 'image', 'sys_file', '%s'
                    )",
                    $sysFile['uid'],
                    $contentElementUid,
                    $description
                )
            );
        }
    }
}
