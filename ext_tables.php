<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility as ExtbaseExtensionUtility;
use Dreadwarrior\Vantomas\Utility\ExtensionManagement as VantomasExtensionUtility;

ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Static', 'van-tomas.de Website package');

// -- archive plugins

// -- 1. archive list

ExtbaseExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'ArchiveList',
	'van-tomas.de - Archive list functionality'
);

VantomasExtensionUtility::addPluginFlexform($_EXTKEY, 'ArchiveList', 'Archive/List.xml');

// -- 2. archive search

ExtbaseExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'ArchiveSearch',
	'van-tomas.de - Archive search functionality'
);

VantomasExtensionUtility::addPluginFlexform($_EXTKEY, 'ArchiveSearch', 'Archive/Search.xml');

// -- page statistics plugins

// -- 1. most popular pages

ExtbaseExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'PageStatisticsMostPopular',
	'van-tomas.de - Most popular pages'
);

VantomasExtensionUtility::addPluginFlexform($_EXTKEY, 'PageStatisticsMostPopular', 'PageStatistics/MostPopular.xml');

// -- 2. last updated pages

ExtbaseExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'PageStatisticsLastUpdated',
	'van-tomas.de - Last updated pages'
);

VantomasExtensionUtility::addPluginFlexform($_EXTKEY, 'PageStatisticsLastUpdated', 'PageStatistics/LastUpdated.xml');

// -- comment plugins

// -- 1. latest disqus comments

ExtbaseExtensionUtility::registerPlugin(
	'Dreadwarrior.' . $_EXTKEY,
	'DisqusLatest',
	'van-tomas.de - Latest disqus comments'
);

VantomasExtensionUtility::addPluginFlexform($_EXTKEY, 'DisqusLatest', 'Disqus/Latest.xml');
?>