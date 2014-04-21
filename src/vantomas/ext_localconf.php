<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

\FluidTYPO3\Flux\Core::registerProviderExtensionKey('DreadLabs.Vantomas', 'Page');
\FluidTYPO3\Flux\Core::registerProviderExtensionKey('DreadLabs.Vantomas', 'Content');

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
		'Archive' => 'search'
	)
);

// -- page statistics plugins

// -- 1. most popular pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'PageStatisticsMostPopular',
	array(
		'PageStatistics' => 'mostPopular'
	),
	array()
);

// -- 2. last updated pages

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

// -- ext:comments -> disqus export task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['taskcenter']['sys_action']['Dreadwarrior\\Vantomas\\Task\\CommentsDisqusExportTask'] = array(
	'title' => 'ext:comments -> Disqus export task',
	'description' => 'will export ext:comments records to the generic Disqus import rss XML',
	'icon' => 'EXT:sys_action/sys_action.gif'
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

// register contact form mailing handler
//$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
$signalSlotDispatcher->connect('DreadLabs\\Controller\\FormController', 'sendContactForm', 'DreadLabs\\Mailer\\ContactForm', 'send');

$cdnInterceptor = 'EXT:vantomas/Classes/Hook/TypoScriptFrontendControllerHook.php:&DreadLabs\\Vantomas\\Hook\\TypoScriptFrontendControllerHook->interceptCdnReplacements';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = $cdnInterceptor;
?>