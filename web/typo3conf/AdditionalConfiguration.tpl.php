<?php
/*$TYPO3_CONF_VARS['BE']['defaultUserTSconfig']="
";*/
$TYPO3_CONF_VARS['BE']['defaultPageTSconfig']="
TCEFORM.pages.TSconfig.linkTitleToSelf=1
";

$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = '${TYPO3_CONF_VARS.SYS.displayErrors}';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = '${TYPO3_CONF_VARS.SYS.trustedHostsPattern}';

$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth'][\DreadLabs\Vantomas\Authentication\Frontend\ThreatDetection::class]['secret'] = '${TYPO3_CONF_VARS.SVCONF.auth.ThreatDetection.secret}';
