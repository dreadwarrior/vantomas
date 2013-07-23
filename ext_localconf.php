<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

use TYPO3\CMS\Extbase\Utility\ExtensionUtility as ExtbaseExtensionUtility;

Tx_Flux_Core::registerProviderExtensionKey('vantomas', 'Page');
Tx_Flux_Core::registerProviderExtensionKey('vantomas', 'Content');

// -- archive plugins

// -- 1. archive list

ExtbaseExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveList',
	array(
		'Archive' => 'list'
	),
	array()
);

// -- 2. archive search

ExtbaseExtensionUtility::configurePlugin(
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

ExtbaseExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'PageStatisticsMostPopular',
	array(
		'PageStatistics' => 'mostPopular'
	),
	array()
);

// -- 2. last updated pages

ExtbaseExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'PageStatisticsLastUpdated',
	array(
		'PageStatistics' => 'lastUpdated'
	),
	array()
);

// -- comment plugins

// -- 1. latest disqus comments

ExtbaseExtensionUtility::configurePlugin(
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
?>