<?php

use Phinx\Migration\AbstractMigration;

class FinallyDeleteTtcontentRecords extends AbstractMigration
{
    /**
     * Finally removes all tt_content records with deleted = 1
     *
     * @return void
     */
    public function up()
    {
        $this->execute("DELETE FROM tt_content WHERE deleted = 1");
    }
}
