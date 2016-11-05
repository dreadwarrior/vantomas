<?php

use Phinx\Migration\AbstractMigration;

class UpdateTypo3Cms7612 extends AbstractMigration
{
    /**
     * Up
     *
     * @return void
     */
    public function up()
    {
        $this->execute("ALTER TABLE sys_file_reference ADD KEY uid_local (uid_local)");
    }
}
