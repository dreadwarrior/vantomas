<?php

use Phinx\Migration\AbstractMigration;

class UpdateTypo3Cms74 extends AbstractMigration
{
    /**
     * Executes all migrations which the install tool has shown
     *
     * @return void
     */
    public function update()
    {
        // Add fields to tables
        $this->execute("ALTER TABLE be_users ADD description varchar(2000) NOT NULL default ''");
        $this->execute("ALTER TABLE be_users ADD avatar int(11) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE pages ADD tsconfig_includes text");
        $this->execute("ALTER TABLE sys_filemounts ADD description varchar(2000) NOT NULL default ''");
        $this->execute("ALTER TABLE sys_file_collection ADD recursive tinyint(4) NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD editlock tinyint(4) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD rowDescription text");
        $this->execute("ALTER TABLE tt_content ADD table_caption varchar(255) default NULL");
        $this->execute("ALTER TABLE tt_content ADD table_delimiter smallint(6) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD table_enclosure smallint(6) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD table_header_position tinyint(3) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD table_tfoot tinyint(1) unsigned NOT NULL default '0'");

        // Change fields
        // Current value: text
        $this->execute("ALTER TABLE be_groups CHANGE description description varchar(2000) NOT NULL default ''");
        // Current value: varchar(20) NOT NULL default ''
        $this->execute("ALTER TABLE sys_log CHANGE NEWid NEWid varchar(30) NOT NULL default ''");
        // Current value: varchar(150) NOT NULL default ''
        $this->execute("ALTER TABLE tx_extensionmanager_domain_model_extension CHANGE author_name author_name varchar(255) NOT NULL default ''");
        // Current value: varchar(150) NOT NULL default ''
        $this->execute("ALTER TABLE tx_extensionmanager_domain_model_extension CHANGE author_email author_email varchar(255) NOT NULL default ''");
        // Current value: varchar(150) NOT NULL default ''
        $this->execute("ALTER TABLE tx_extensionmanager_domain_model_extension CHANGE authorcompany authorcompany varchar(255) NOT NULL default ''");
        // Current value: tinytext NOT NULL
        $this->execute("ALTER TABLE tt_content CHANGE filelink_sorting filelink_sorting varchar(10) NOT NULL default ''");
        // Current value: text NOT NULL
        $this->execute("ALTER TABLE tx_scheduler_task CHANGE lastexecution_failure lastexecution_failure text");

        // remove unused fields
        //  storage_pid int(11) NOT NULL default '0'
        $this->execute("ALTER TABLE pages DROP storage_pid");
        // spaceBefore smallint(5) unsigned NOT NULL default '0'
        $this->execute("ALTER TABLE tt_content DROP spaceBefore");
        // spaceAfter smallint(5) unsigned NOT NULL default '0'
        $this->execute("ALTER TABLE tt_content DROP spaceAfter");
        // image_noRows tinyint(3) unsigned NOT NULL default '0'
        $this->execute("ALTER TABLE tt_content DROP image_noRows");
        // image_effects tinyint(3) unsigned NOT NULL default '0'
        $this->execute("ALTER TABLE tt_content DROP image_effects");
        // image_compression tinyint(3) unsigned NOT NULL default '0'
        $this->execute("ALTER TABLE tt_content DROP image_compression");
        // section_frame int(11) unsigned NOT NULL default '0'
        $this->execute("ALTER TABLE tt_content DROP section_frame");
        // image_frames int(11) unsigned NOT NULL default '0'
        $this->execute("ALTER TABLE tt_content DROP image_frames");
        // rte_enabled tinyint(4) NOT NULL default '0'
        $this->execute("ALTER TABLE tt_content DROP rte_enabled");
    }
}
