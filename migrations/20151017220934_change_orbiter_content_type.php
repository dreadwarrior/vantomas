<?php

use Phinx\Migration\AbstractMigration;

class ChangeOrbiterContentType extends AbstractMigration
{
    /**
     * Updates the orbiter CType value
     *
     * @return void
     */
    public function up()
    {
        $this->execute(
            "UPDATE tt_content SET CType = 'vantomas_orbiter', tx_fed_fcefile = '' WHERE tx_fed_fcefile = 'DreadLabs.Vantomas:Orbiter.html' OR tx_fed_fcefile = 'vantomas:Orbiter.html'"
        );
    }
}
