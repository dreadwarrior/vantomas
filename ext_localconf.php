<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'ArchiveList',
	array(
		'Archive' => 'list'
	),
	array( // don't cache some actions
	)
);

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
?>