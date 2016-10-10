<?php

use Phinx\Migration\AbstractMigration;

class Realurl2xUpgrade extends AbstractMigration
{
    /**
     * Up
     *
     * @return void
     */
    public function up()
    {
        $this->query("ALTER TABLE tx_realurl_pathcache CHANGE cache_id uid int(11) NOT NULL");
        $this->query("ALTER TABLE tx_realurl_pathcache DROP PRIMARY KEY");
        $this->query("ALTER TABLE tx_realurl_pathcache MODIFY uid int(11) NOT NULL auto_increment primary key");
        $this->query("DROP TABLE tx_realurl_chashcache");
        $this->query("DROP TABLE tx_realurl_urldecodecache");
        $this->query("DROP TABLE tx_realurl_urlencodecache");
        $this->query("DROP TABLE tx_realurl_errorlog");
    }
}
