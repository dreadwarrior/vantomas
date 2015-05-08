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
