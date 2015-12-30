<?php

use Phinx\Migration\AbstractMigration;

class UpdateTypo3Cms762 extends AbstractMigration
{
    /**
     * Up
     *
     * @return void
     */
    public function up()
    {
        $this->execute('ALTER TABLE sys_category CHANGE description description text');
        $this->execute('ALTER TABLE fe_groups CHANGE description description text');
        $this->execute('ALTER TABLE fe_groups CHANGE subgroup subgroup tinytext');
        $this->execute('ALTER TABLE fe_groups CHANGE TSconfig TSconfig text');
        $this->execute("ALTER TABLE tt_content CHANGE list_type list_type varchar(255) NOT NULL default ''");
        $this->execute("ALTER TABLE backend_layout CHANGE description description text");
        $this->execute("ALTER TABLE tx_scheduler_task CHANGE description description text");
        $this->execute("ALTER TABLE tx_scheduler_task_group CHANGE description description text");
    }
}
