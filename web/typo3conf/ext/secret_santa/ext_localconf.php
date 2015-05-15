<?php
if (!defined('TYPO3_MODE')) {
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

/* @var $signalSlotDispatcher \TYPO3\CMS\Extbase\SignalSlot\Dispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility
	::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class)
	->get(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
	\DreadLabs\SecretSanta\Domain\Donee\Resolver::class,
	'foundDonee',
	\DreadLabs\SecretSanta\Domain\Observer\PairPersister::class,
	'persist'
);
