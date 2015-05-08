<?php
return array(
	'ctrl' => array (
		'title' => 'LLL:EXT:secret_santa/Resources/Private/Language/locallang_db.xlf:tx_secretsanta_domain_model_pair',
		'label' => 'uid',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Pair.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_secretsanta_domain_model_pair.gif',
	),
	'interface' => array (
		'showRecordFieldList' => 'hidden,donor,donee'
	),
	'columns' => array (
		'hidden' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array (
				'type' => 'check',
				'default' => '0'
			)
		),
		'donor' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:secret_santa/Resources/Private/Language/locallang_db.xlf:tx_secretsanta_domain_model_pair.donor',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'fe_users',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'donee' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:secret_santa/Resources/Private/Language/locallang_db.xlf:tx_secretsanta_domain_model_pair.donee',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'fe_users',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, donor, donee')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
