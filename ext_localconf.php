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
	array()
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

// -- comment plugins

// -- 1. latest comments

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'CommentLatest',
	array(
		'Comment' => 'latest'
	),
	array()
);

$extCommentsMarkerHook = 'EXT:vantomas/Classes/Hooks/Comments/Marker.php:&Tx_Vantomas_Hooks_Comments_Marker->comments_getComments';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['comments_getComments']['comments_marker'] = $extCommentsMarkerHook;
?>