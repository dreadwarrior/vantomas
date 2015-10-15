<?php

use Phinx\Migration\AbstractMigration;

class RemoveFluidcontentCoreTtcontentColumns extends AbstractMigration
{
    /**
     * Removes tt_content columns after fluidcontent_core removal
     *
     * @return void
     */
    public function up()
    {
        $this->execute("ALTER TABLE tt_content DROP content_options");
        $this->execute("ALTER TABLE tt_content DROP content_variant");
        $this->execute("ALTER TABLE tt_content DROP content_version");
    }
}
