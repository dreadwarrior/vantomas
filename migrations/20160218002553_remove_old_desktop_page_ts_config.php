<?php

use Phinx\Migration\AbstractMigration;

class RemoveOldDesktopPageTsConfig extends AbstractMigration
{
    /**
     * Up
     *
     * @return void
     */
    public function up()
    {
        $this->execute("UPDATE pages SET TSconfig = REPLACE(TSconfig, '<INCLUDE_TYPOSCRIPT: source=\"FILE:EXT:vantomas/Configuration/TypoScript/TSConfig/Page/Desktop/index.ts\">', '')");
    }
}
