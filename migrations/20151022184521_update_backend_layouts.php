<?php

use Phinx\Migration\AbstractMigration;

class UpdateBackendLayouts extends AbstractMigration
{
    /**
     * Updates the backend layouts to use ext:vantomas layouts
     *
     * @return void
     */
    public function up()
    {
        $this->execute("UPDATE pages SET backend_layout = 'vantomas__Wide' WHERE tx_fed_page_controller_action = 'DreadLabs.Vantomas->Wide' OR tx_fed_page_controller_action = 'vantomas->Wide'");
        $this->execute("UPDATE pages SET backend_layout = 'vantomas__Standard' WHERE tx_fed_page_controller_action = 'DreadLabs.Vantomas->Standard' OR tx_fed_page_controller_action = 'vantomas->Standard'");
        $this->execute("UPDATE pages SET backend_layout = 'vantomas__Blog' WHERE tx_fed_page_controller_action = 'DreadLabs.Vantomas->Blog' OR tx_fed_page_controller_action = 'vantomas->Blog'");
        $this->execute("UPDATE pages SET backend_layout_next_level = 'vantomas__Wide' WHERE tx_fed_page_controller_action_sub = 'DreadLabs.Vantomas->Wide' OR tx_fed_page_controller_action_sub = 'vantomas->Wide'");
        $this->execute("UPDATE pages SET backend_layout_next_level = 'vantomas__Standard' WHERE tx_fed_page_controller_action_sub = 'DreadLabs.Vantomas->Standard' OR tx_fed_page_controller_action_sub = 'vantomas->Standard'");
        $this->execute("UPDATE pages SET backend_layout_next_level = 'vantomas__Blog' WHERE tx_fed_page_controller_action_sub = 'DreadLabs.Vantomas->Blog' OR tx_fed_page_controller_action_sub = 'vantomas->Blog'");
    }
}
