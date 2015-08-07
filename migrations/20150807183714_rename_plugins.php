<?php

use Phinx\Migration\AbstractMigration;

class RenamePlugins extends AbstractMigration
{
    /**
     * Rename plugins
     *
     * @return void
     */
    public function up()
    {
        $this->execute("UPDATE tt_content SET list_type = 'vantomas_sitelastupdatedpages' WHERE list_type = 'vantomas_pagestatisticslastupdated'");
        $this->execute("UPDATE tt_content SET list_type = 'vantomas_secretsantarevealdonee' WHERE list_type = 'vantomas_secretsanta'");
    }
}
