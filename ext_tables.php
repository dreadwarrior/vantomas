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

?>