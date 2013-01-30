<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

// -- archive plugins

// -- 1. archive list

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'ArchiveList',
	array(
		'Archive' => 'list'
	),
	array( // don't cache some actions
	)
);

// -- 2. archive search

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
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

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'PageStatisticsMostPopular',
	array(
		'PageStatistics' => 'mostPopular'
	),
	array()
);

// -- 2. last updated pages

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'PageStatisticsLastUpdated',
	array(
		'PageStatistics' => 'lastUpdated'
	),
	array()
);
?>