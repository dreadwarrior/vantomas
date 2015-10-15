<?php

use Phinx\Migration\AbstractMigration;

class HidePluginsHeader extends AbstractMigration
{
    /**
     * The header is hidden for plugins with fluidcontent_core
     *
     * @return void
     */
    public function up()
    {
        $this->execute("UPDATE tt_content SET header_layout = 100 WHERE CType = 'list'");
    }
}
