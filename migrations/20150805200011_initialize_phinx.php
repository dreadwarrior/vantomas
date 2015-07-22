<?php

use Phinx\Migration\AbstractMigration;

class InitializePhinx extends AbstractMigration
{

    /**
     * Creates the phinxlog table
     *
     * @return void
     */
    public function up()
    {
        if (!$this->hasTable('phinxlog')) {
            $this->table('phinxlog', array('id' => FALSE))
                ->addColumn('version', 'biginteger')
                ->addColumn('start_time', 'timestamp')
                ->addColumn('end_time', 'timestamp')
                ->save();
        }
    }
}
