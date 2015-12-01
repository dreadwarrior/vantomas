<?php

use Phinx\Migration\AbstractMigration;

class UpdateTypo3Cms76 extends AbstractMigration
{
    /**
     * Up
     *
     * @return void
     */
    public function up()
    {
        $this->execute("ALTER TABLE pages_language_overlay ADD t3ver_move_id int(11) NOT NULL default '0'");
        $this->execute("ALTER TABLE sys_template ADD t3ver_move_id int(11) NOT NULL default '0'");
    }
}
