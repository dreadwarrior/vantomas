<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_secretsanta_domain_model_pair'] = array (
	'ctrl' => $TCA['tx_secretsanta_domain_model_pair']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,donor,donee'
	),
	'feInterface' => $TCA['tx_secretsanta_domain_model_pair']['feInterface'],
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
