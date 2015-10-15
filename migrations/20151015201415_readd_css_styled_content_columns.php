<?php

use Phinx\Migration\AbstractMigration;

class ReaddCssStyledContentColumns extends AbstractMigration
{
    /**
     * Re-adds tt_content columns after fluidcontent_core deinstallation
     *
     * @return void
     */
    public function up()
    {
        $this->execute("ALTER TABLE tt_content ADD image_compression tinyint(3) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD image_effects tinyint(3) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD image_noRows tinyint(3) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD section_frame int(11) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD spaceAfter smallint(5) unsigned NOT NULL default '0'");
        $this->execute("ALTER TABLE tt_content ADD spaceBefore smallint(5) unsigned NOT NULL default '0'");
    }
}
