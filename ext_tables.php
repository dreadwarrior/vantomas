<?php

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Static/Desktop', 'van-tomas.de Website package - desktop version');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Static/Mobile', 'van-tomas.de Website package - mobile version');

// -- archive plugins

// -- 1. archive list

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'ArchiveList',
	'van-tomas.de - Archive list functionality'
);

Tx_Vantomas_Utility_ExtensionManagement::addPluginFlexform($_EXTKEY, 'ArchiveList', 'Archive/List.xml');

// -- 2. archive search

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'ArchiveSearch',
	'van-tomas.de - Archive search functionality'
);

Tx_Vantomas_Utility_ExtensionManagement::addPluginFlexform($_EXTKEY, 'ArchiveSearch', 'Archive/Search.xml');

// -- page statistics plugins

// -- 1. most popular pages

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'PageStatisticsMostPopular',
	'van-tomas.de - Most popular pages'
);

Tx_Vantomas_Utility_ExtensionManagement::addPluginFlexform($_EXTKEY, 'PageStatisticsMostPopular', 'PageStatistics/MostPopular.xml');

// -- 2. last updated pages

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'PageStatisticsLastUpdated',
	'van-tomas.de - Last updated pages'
);

Tx_Vantomas_Utility_ExtensionManagement::addPluginFlexform($_EXTKEY, 'PageStatisticsLastUpdated', 'PageStatistics/LastUpdated.xml');

// -- comment plugins

// -- 1. latest disqus comments

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'DisqusLatest',
	'van-tomas.de - Latest disqus comments'
);

Tx_Vantomas_Utility_ExtensionManagement::addPluginFlexform($_EXTKEY, 'DisqusLatest', 'Disqus/Latest.xml');
?>