<?php

use Phinx\Migration\AbstractMigration;

class HidePageAbstractHeader extends AbstractMigration
{
    /**
     * The page abstract CE header must be hidden too
     *
     * @return void
     */
    public function up()
    {
        $this->execute(
            "UPDATE tt_content SET header_layout = 100 WHERE tx_fed_fcefile = 'DreadLabs.Vantomas:PageAbstract.html'"
        );
    }
}
