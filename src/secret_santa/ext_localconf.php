<?php
if (!defined ('TYPO3_MODE')) {
 	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'Randomizer',
	array(
		'Randomizer' => 'randomize'
	),
	array(
		'Randomizer' => 'randomize'
	)
);
?>