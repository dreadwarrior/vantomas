<?php

use Phinx\Migration\AbstractMigration;

class RemoveFluidTypo3SuiteFields extends AbstractMigration
{
    /**
     * Removes fields for FluidTYPO3 suite extensions
     *
     * @return void
     */
    public function up()
    {
        $this->execute("ALTER TABLE pages DROP COLUMN tx_fed_page_flexform");
        $this->execute("ALTER TABLE pages DROP COLUMN tx_fed_page_controller_action");
        $this->execute("ALTER TABLE pages DROP COLUMN tx_fed_page_controller_action_sub");
        $this->execute("ALTER TABLE pages DROP COLUMN tx_fed_page_flexform_sub");
        $this->execute("ALTER TABLE pages DROP COLUMN tx_fluidpages_templatefile");
        $this->execute("ALTER TABLE pages DROP COLUMN tx_fluidpages_layout");
        $this->execute("ALTER TABLE tt_content DROP COLUMN tx_fed_fcefile");
    }
}
