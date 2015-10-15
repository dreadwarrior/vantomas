<?php

use Phinx\Migration\AbstractMigration;

class ReaddStaticCssStyledContentTypoScriptTemplate extends AbstractMigration
{
    /**
     * Readds the static typoscript template of ext:css_styled content
     *
     * @return void
     */
    public function up()
    {
        $this->execute("UPDATE sys_template SET include_static_file = CONCAT('EXT:css_styled_content/static/', ',', include_static_file) WHERE root = 1 AND include_static_file NOT LIKE '%css_styled_content%'");
    }
}