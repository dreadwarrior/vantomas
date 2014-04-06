<?php
/*$TYPO3_CONF_VARS['BE']['defaultUserTSconfig']="
";*/
$TYPO3_CONF_VARS['BE']['defaultPageTSconfig']="
TCEFORM.pages.TSconfig.linkTitleToSelf=1
";
${hosting.image_magick_putenv}

$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = '{$TYPO3_CONF_VARS.SYS.displayErrors}';

$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'] = array('fluidcontentcore/Configuration/TypoScript/');
?>