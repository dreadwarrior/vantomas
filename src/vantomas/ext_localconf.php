<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// -- adjust autoloading

require PATH_site . '/../vendor/composer/ClassLoader.php';

/* @var $composerAutoloader \Composer\Autoload\ClassLoader */
$composerAutoloader = new \Composer\Autoload\ClassLoader();

// add only things we actually need during runtime
$composerAutoloader->add('Net_', PATH_site . '/../vendor/net/http/src/');
$composerAutoloader->add('Illuminate\\Support', PATH_site . '/../vendor/illuminate/support/');
$composerAutoloader->add('Arg\\Tagcloud', PATH_site . '/../vendor/arg/tagcloud/src/');
$composerAutoloader->addPsr4('DreadLabs\\Net\\', PATH_site . '/../src/DreadLabs/Net/');
$composerAutoloader->addPsr4('DreadLabs\\VantomasWebsite\\', PATH_site . '/../src/DreadLabs/VantomasWebsite/');

// register autoloading
$composerAutoloader->register(TRUE);

\FluidTYPO3\Flux\Core::registerProviderExtensionKey(
	'DreadLabs.Vantomas',
	'Page'
);
\FluidTYPO3\Flux\Core::registerProviderExtensionKey(
	'DreadLabs.Vantomas',
	'Content'
);

// -- archive plugins

// -- 1. archive list

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveList',
	array(
		'Archive' => 'list'
	),
	array()
);

// -- 2. archive search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveSearch',
	array(
		'Archive' => 'search'
	),
	array(
// 		'Archive' => 'search'
	)
);

// -- page statistics plugins

// -- 1. last updated pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'PageStatisticsLastUpdated',
	array(
		'PageStatistics' => 'lastUpdated'
	),
	array()
);

// -- comment plugins

// -- 1. latest disqus comments

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'DisqusLatest',
	array(
		'Disqus' => 'latest'
	),
	array()
);

// -- twitter plugins

// -- 1. timeline tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TwitterTimeline',
	array(
		'Twitter' => 'timeline'
	),
	array()
);

// -- 2. search tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TwitterSearch',
	array(
		'Twitter' => 'search'
	),
	array()
);

// -- tag cloud/search plugins

// -- 1. tag cloud

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagCloud',
	array(
		'Tag' => 'cloud'
	),
	array()
);

// -- 2. tag search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagSearch',
	array(
		'Tag' => 'search'
	),
	array()
);

// -- contact form

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ContactForm',
	array(
		'Form' => 'newContact, sendContact, success',
	),
	array(
		'Form' => 'newContact, sendContact, success',
	)
);

// -- RSS feed

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'RssFeed',
	array(
		'Rss' => 'feed'
	),
	array(
	)
);

// -- sitemap.xml

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'SitemapXml',
	array(
		'Sitemap' => 'xml'
	),
	array()
);

// -- register contact form mailing handler

/* @var $signalSlotDispatcher \TYPO3\CMS\Extbase\SignalSlot\Dispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
	'TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher'
);
$signalSlotDispatcher->connect(
	'DreadLabs\\Vantomas\\Controller\\FormController', 'sendContactForm',
	'DreadLabs\\VantomasWebsite\\MailInterface', 'convey'
);

$cdnInterceptorPath = 'EXT:vantomas/Classes/Hook/TypoScriptFrontendControllerHook.php';
$cdnInterceptorCallable = 'DreadLabs\\Vantomas\\Hook\\TypoScriptFrontendControllerHook->interceptCdnReplacements';
$cdnInterceptor = $cdnInterceptorPath . ':&' . $cdnInterceptorCallable;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = $cdnInterceptor;
?>