<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'van-tomas.de Website package');

// -- archive plugins

// -- 1. archive list

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'ArchiveList',
	'van-tomas.de - Archive list functionality'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform($_EXTKEY, 'ArchiveList', 'Archive/List.xml');

// -- 2. archive search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'ArchiveSearch',
	'van-tomas.de - Archive search functionality'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform($_EXTKEY, 'ArchiveSearch', 'Archive/Search.xml');

// -- page statistics plugins

// -- 1. most popular pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'PageStatisticsMostPopular',
	'van-tomas.de - Most popular pages'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform($_EXTKEY, 'PageStatisticsMostPopular', 'PageStatistics/MostPopular.xml');

// -- 2. last updated pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'PageStatisticsLastUpdated',
	'van-tomas.de - Last updated pages'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform($_EXTKEY, 'PageStatisticsLastUpdated', 'PageStatistics/LastUpdated.xml');

// -- comment plugins

// -- 1. latest disqus comments

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'DisqusLatest',
	'van-tomas.de - Latest disqus comments'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform($_EXTKEY, 'DisqusLatest', 'Disqus/Latest.xml');

// -- twitter plugins

// -- 1. timeline tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'TwitterTimeline',
	'van-tomas.de - Twitter timeline'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform($_EXTKEY, 'TwitterTimeline', 'Twitter/Timeline.xml');

// -- 2. search tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'TwitterSearch',
	'van-tomas.de - Twitter search'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform($_EXTKEY, 'TwitterSearch', 'Twitter/Search.xml');
?>