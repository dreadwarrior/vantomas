<?php

use Phinx\Migration\AbstractMigration;

class DeletePageAbstractContentElement extends AbstractMigration
{
    /**
     * Removes all PageAbstract content elements
     *
     * @return void
     */
    public function up()
    {
        $this->execute("DELETE FROM tt_content WHERE tx_fed_fcefile = 'DreadLabs.Vantomas:PageAbstract.html'");
    }
}
