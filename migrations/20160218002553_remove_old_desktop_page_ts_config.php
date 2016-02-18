<?php

use Phinx\Migration\AbstractMigration;

class RemoveOldDesktopPageTsConfig extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     */
    public function up()
    {
        $this->execute("UPDATE pages SET TSconfig = REPLACE(TSconfig, '<INCLUDE_TYPOSCRIPT: source=\"FILE:EXT:vantomas/Configuration/TypoScript/TSConfig/Page/Desktop/index.ts\">', '')");
    }
}
