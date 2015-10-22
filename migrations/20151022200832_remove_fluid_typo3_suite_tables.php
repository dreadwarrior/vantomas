<?php

use Phinx\Migration\AbstractMigration;

class RemoveFluidTypo3SuiteTables extends AbstractMigration
{
    /**
     * Removes tables of FluidTYPO3 suite extensions
     *
     * @return void
     */
    public function up()
    {
        $this->execute("DROP TABLE cf_fluidcontent");
        $this->execute("DROP TABLE cf_fluidcontent_tags");
    }
}
