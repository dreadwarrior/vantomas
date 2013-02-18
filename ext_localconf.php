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

// -- 1. latest disqus comments

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'DisqusLatest',
	array(
		'Disqus' => 'latest'
	),
	array()
);

// -- ext:comments -> disqus export task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['taskcenter']['sys_action']['Tx_Vantomas_Task_CommentsDisqusExportTask'] = array(
	'title' => 'ext:comments -> Disqus export task',
	'description' => 'will export ext:comments records to the generic Disqus import rss XML',
	'icon' => 'EXT:sys_action/sys_action.gif'
);

// -- ext:beautyofcode addJS_setHeaderData hook
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['beautyofcode']['addJS_setHeaderData'][] = t3lib_extMgm::extPath('vantomas', 'Classes/Hook/Extension/Beautyofcode.php') . ':Tx_Vantomas_Hook_Extension_Beautyofcode->handleInlineCode';
?>