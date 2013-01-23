<?php

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Static/Desktop', 'van-tomas.de Website package - desktop version');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Static/Mobile', 'van-tomas.de Website package - mobile version');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'ArchiveList',
	'van-tomas.de - Archive list functionality'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'ArchiveSearch',
	'van-tomas.de - Archive search functionality'
);

?>