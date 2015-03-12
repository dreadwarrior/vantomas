<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript/Site',
	'van-tomas.de Website package'
);

// -- additional static TS

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript/LabsCustomTag',
	'Labs: custom RTE tag'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript/Wichteln',
	'van-tomas.de Wichteln'
);

// -- archive plugins

// -- 1. archive list

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveList',
	'van-tomas.de - Archive list functionality'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'ArchiveList',
	'Archive/List.xml'
);

// -- 2. archive search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveSearch',
	'van-tomas.de - Archive search functionality'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'ArchiveSearch',
	'Archive/Search.xml'
);

// -- page statistics plugins

// -- 1. last updated pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'PageStatisticsLastUpdated',
	'van-tomas.de - Last updated pages'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'PageStatisticsLastUpdated',
	'PageStatistics/LastUpdated.xml'
);

// -- comment plugins

// -- 1. latest disqus comments

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'DisqusLatest',
	'van-tomas.de - Latest disqus comments'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'DisqusLatest',
	'Disqus/Latest.xml'
);

// -- twitter plugins

// -- 1. timeline tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'TwitterTimeline',
	'van-tomas.de - Twitter timeline'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'TwitterTimeline',
	'Twitter/Timeline.xml'
);

// -- 2. search tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'TwitterSearch',
	'van-tomas.de - Twitter search'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'TwitterSearch',
	'Twitter/Search.xml'
);

// -- tag cloud/search plugins

// -- 1. tag cloud

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagCloud',
	'van-tomas.de - Tag cloud'
);

// -- 2. tag search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagSearch',
	'van-tomas.de - Tag search'
);

// -- contact form

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'ContactForm',
	'van-tomas.de - Contact form'
);


\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'ContactForm',
	'Form/Contact.xml'
);

// -- feature: RTE 4 abstract

$extConf = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['vantomas']);

\DreadLabs\Vantomas\Utility\ExtensionManagement\PageAbstractRte::configure($extConf);

$pagesAbstractRteTcaExtras = 'richtext:rte_transform[flag=rte_enabled|mode=ts_css]';
$GLOBALS['TCA']['pages']['columns']['abstract']['defaultExtras'] = $pagesAbstractRteTcaExtras;

?>