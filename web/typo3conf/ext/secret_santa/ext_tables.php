<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// -- TypoScript

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript/',
	'Secret Santa'
);

// -- TCA

$TCA['tx_secretsanta_domain_model_pair'] = array (
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
);

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_randomizer'] = 'layout,select_key';

// -- plugin registration

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'Randomizer',
	'LLL:EXT:secret_santa/Resources/Private/Language/locallang_db.xlf:plugin.randomizer.title'
);

// -- new content element wizard icon registration

if (TYPO3_MODE == 'BE') {
	$secretSantaNewContentElementWizardItem = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath(
		$_EXTKEY,
		'Classes/Hooks/NewContentElementWizardIconHook.php'
	);
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['DreadLabs\\SecretSanta\\Hooks\\NewContentElementWizardIconHook'] = $secretSantaNewContentElementWizardItem;
}