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

// -- 2. archive search

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'ArchiveSearch',
	'van-tomas.de - Archive search functionality'
);

// -- page statistics plugins

// -- 1. most popular pages

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'PageStatisticsMostPopular',
	'van-tomas.de - Most popular pages'
);

// -- 2. last updated pages

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'PageStatisticsLastUpdated',
	'van-tomas.de - last updated pages'
);

$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginName = 'PageStatisticsLastUpdated';

$pluginSignature = strtolower($extensionName . '_' . $pluginName);

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/Flexform/PageStatistics/LastUpdated.xml');

// -- comment plugins

// -- 1. latest comments

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'CommentLatest',
	'van-tomas.de - Latest comments'
);

$pluginName = 'CommentLatest';

$pluginSignature = strtolower($extensionName . '_' . $pluginName);

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/Flexform/Comment/Latest.xml');
?>