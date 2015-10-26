<?php

use Phinx\Migration\AbstractMigration;

class UpdateTypo3Cms75 extends AbstractMigration
{
    /**
     * Up
     *
     * @return void
     */
    public function up()
    {
        // add fields to tables
        $this->execute("ALTER TABLE sys_file_storage ADD auto_extract_metadata tinyint(4) NOT NULL default '1'");
        $this->execute("ALTER TABLE sys_file_reference ADD autoplay tinyint(4) NOT NULL default '0'");

        // change fields
        $this->execute("ALTER TABLE pages CHANGE media media int(11) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE sys_log CHANGE details_nr details_nr tinyint(3) NOT NULL default '0'");
        $this->execute("ALTER TABLE pages_language_overlay CHANGE media media int(11) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content CHANGE image image int(11) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content CHANGE media media int(11) unsigned NOT NULL default '0'");
    }
}
