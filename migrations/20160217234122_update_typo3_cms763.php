<?php

use Phinx\Migration\AbstractMigration;

class UpdateTypo3Cms763 extends AbstractMigration
{
    /**
     * Up
     *
     * @return void
     */
    public function up()
    {
        $this->execute('ALTER TABLE sys_file_collection CHANGE folder folder text');
    }
}
