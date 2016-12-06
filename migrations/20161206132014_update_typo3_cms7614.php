<?php

use Phinx\Migration\AbstractMigration;

class UpdateTypo3Cms7614 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     */
    public function change()
    {
        $this->execute("ALTER TABLE pages CHANGE module module varchar(255) NOT NULL default ''");
        // Current value: varchar(10) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE visible visible int(11) unsigned default '1'");
        // Current value: int(11) unsigned NOT NULL default '1'
        $this->execute("ALTER TABLE sys_file_metadata CHANGE status status varchar(24) default ''");
        // Current value: varchar(24) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE keywords keywords text");
        // Current value: text NOT NULL
        $this->execute("ALTER TABLE sys_file_metadata CHANGE caption caption text");
        // Current value: varchar(255) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE creator_tool creator_tool varchar(255) default ''");
        // Current value: varchar(255) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE download_name download_name varchar(255) default ''");
        // Current value: varchar(255) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE creator creator varchar(255) default ''");
        // Current value: varchar(255) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE publisher publisher varchar(45) default ''");
        // Current value: varchar(45) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE source source varchar(255) default ''");
        // Current value: varchar(255) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE copyright copyright text");
        // Current value: varchar(255) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE location_country location_country varchar(45) default ''");
        // Current value: varchar(45) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE location_region location_region varchar(45) default ''");
        // Current value: varchar(45) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE location_city location_city varchar(45) default ''");
        // Current value: varchar(45) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE latitude latitude decimal(24,14) default '0.00000000000000'");
        // Current value: decimal(24,14) NOT NULL default '0.00000000000000'
        $this->execute("ALTER TABLE sys_file_metadata CHANGE longitude longitude decimal(24,14) default '0.00000000000000'");
        // Current value: decimal(24,14) NOT NULL default '0.00000000000000'
        $this->execute("ALTER TABLE sys_file_metadata CHANGE note note text");
        // Current value: text NOT NULL
        $this->execute("ALTER TABLE sys_file_metadata CHANGE unit unit char(3) default ''");
        // Current value: char(3) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE duration duration float unsigned default '0'");
        // Current value: float unsigned NOT NULL default '0'
        $this->execute("ALTER TABLE sys_file_metadata CHANGE color_space color_space varchar(4) default ''");
        // Current value: varchar(4) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE pages pages int(4) unsigned default '0'");
        // Current value: int(4) unsigned NOT NULL default '0'
        $this->execute("ALTER TABLE sys_file_metadata CHANGE language language varchar(12) default ''");
        // Current value: varchar(12) NOT NULL default ''
        $this->execute("ALTER TABLE sys_file_metadata CHANGE fe_groups fe_groups tinytext");
        // Current value: tinytext NOT NULL
        $this->execute("ALTER TABLE sys_refindex CHANGE field field varchar(64) NOT NULL default ''");
        // Current value: varchar(40) NOT NULL default ''
    }
}
