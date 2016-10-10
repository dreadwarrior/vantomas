<?php

use Phinx\Migration\AbstractMigration;

class Realurl2xInstall extends AbstractMigration
{
    /**
     * Up
     *
     * @return void
     */
    public function up()
    {
        $this->query("CREATE TABLE tx_realurl_uniqalias_cache_map ( alias_uid int(11) NOT NULL default '0', url_cache_id int(11) NOT NULL default '0', KEY check_existence (alias_uid,url_cache_id) ) ENGINE=InnoDB");
        $this->query("CREATE TABLE tx_realurl_urldata ( uid int(11) NOT NULL auto_increment, pid int(11) NOT NULL default '0', crdate int(11) NOT NULL default '0', page_id int(11) NOT NULL default '0', rootpage_id int(11) NOT NULL default '0', original_url text, speaking_url text, request_variables text, expire int(11) NOT NULL default '0', PRIMARY KEY (uid), KEY parent (pid), KEY pathq1 (rootpage_id,original_url(32),expire), KEY pathq2 (rootpage_id,speaking_url(32)), KEY page_id (page_id) ) ENGINE=InnoDB");
        $this->query("CREATE TABLE tx_realurl_pathdata ( uid int(11) NOT NULL auto_increment, pid int(11) NOT NULL default '0', page_id int(11) NOT NULL default '0', language_id int(11) NOT NULL default '0', rootpage_id int(11) NOT NULL default '0', mpvar tinytext, pagepath text, expire int(11) NOT NULL default '0', PRIMARY KEY (uid), KEY parent (pid), KEY pathq1 (rootpage_id,pagepath(32),expire), KEY pathq2 (page_id,language_id,rootpage_id,expire), KEY expire (expire) ) ENGINE=InnoDB");
        $this->query("ALTER TABLE tx_realurl_uniqalias ADD pid int(11) NOT NULL default '0'");
        $this->query("ALTER TABLE tx_realurl_uniqalias ADD KEY parent (pid)");
        $this->query("ALTER TABLE tx_realurl_uniqalias ENGINE=InnoDB");
        $this->query("DROP TABLE tx_realurl_pathcache");
        $this->query("DROP TABLE tx_realurl_redirects");
        $this->query("ALTER TABLE tx_realurl_uniqalias DROP COLUMN tstamp");
        $this->query("ALTER TABLE sys_domain DROP KEY tx_realurl");
        $this->query("ALTER TABLE sys_template DROP KEY tx_realurl");
    }
}
