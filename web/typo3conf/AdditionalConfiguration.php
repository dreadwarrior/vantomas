<?php
$dotenv = new \Dotenv\Dotenv(PATH_site . '/..');
$dotenv->load();


$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword'] = getenv('TCV_BE_INSTALLTOOLPASSWORD');

$GLOBALS['TYPO3_CONF_VARS']['DB']['database'] = getenv('TCV_DB_DATABASE');
$GLOBALS['TYPO3_CONF_VARS']['DB']['host'] = getenv('TCV_DB_HOST');
$GLOBALS['TYPO3_CONF_VARS']['DB']['password'] = getenv('TCV_DB_PASSWORD');
$GLOBALS['TYPO3_CONF_VARS']['DB']['port'] = getenv('TCV_DB_PORT');
$GLOBALS['TYPO3_CONF_VARS']['DB']['username'] = getenv('TCV_DB_USERNAME');

$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['realurl'] = 'a:5:{s:10:"configFile";s:26:"typo3conf/realurl_conf.php";s:14:"enableAutoConf";s:1:"0";s:14:"autoConfFormat";s:1:"0";s:12:"enableDevLog";s:1:"0";s:19:"enableChashUrlDebug";s:1:"' . getenv('TCV_EXT_EXTCONF_REALURL_ENABLECHASHURLDEBUG') . '";}';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['rsaauth'] = 'a:1:{s:18:"temporaryDirectory";' . getenv('TCV_EXT_EXTCONF_RSAAUTH_TEMPORARYDIRECTORY') . ';}';

$GLOBALS['TYPO3_CONF_VARS']['FE']['pageUnavailable_force'] = getenv('TCV_FE_PAGEUNAVAILABLEFORCE');

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = getenv('TCV_MAIL_TRANSPORT');
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = getenv('TCV_MAIL_TRANSPORT_SMTP_SERVER');
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = getenv('TCV_MAIL_TRANSPORT_SMTP_ENCRYPT');
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = getenv('TCV_MAIL_TRANSPORT_SMTP_USERNAME');
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = getenv('TCV_MAIL_TRANSPORT_SMTP_PASSWORD');

$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth'][\DreadLabs\Vantomas\Authentication\Frontend\ReCaptcha::class]['secret'] = getenv('TCV_SVCONF_AUTH_THREATDETECTION_SECRET');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['backend'] = getenv('TCV_SYS_CACHING_CACHECONFIGURATIONS_EXTBASEOBJECT_BACKEND');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] = getenv('TCV_SYS_DEBUGEXCEPTIONHANDLER');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = getenv('TCV_SYS_DISPLAYERRORS');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = getenv('TCV_SYS_ENABLEDEPRECATIONLOG');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'] = getenv('TCV_SYS_ENCRYPTIONKEY');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler'] = getenv('TCV_SYS_PRODUCTIONEXCEPTIONHANDLER');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = getenv('TCV_SYS_SITENAME');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['systemLog'] = getenv('TCV_SYS_SYSTEMLOG');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['systemLogLevel'] = getenv('TCV_SYS_SYSTEMLOGLEVEL');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = getenv('TCV_SYS_TRUSTEDHOSTSPATTERN');
