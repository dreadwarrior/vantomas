<?php
namespace DreadLabs\Vantomas\Messaging;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * FlashMessageFactory
 *
 * Returns a FlashMessage which gets a translated message and classes prepared
 * for rendering in a zurb foundation empowered frontend context.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FlashMessageFactory {

	/**
	 * The translation catalogue
	 *
	 * @var string
	 */
	private $translationCatalogue;

	/**
	 * DI ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * Constructor
	 *
	 * @param string $translationCatalogue The translation catalogue file reference
	 * @param ObjectManagerInterface $objectManager DI ObjectManager
	 */
	public function __construct(
		$translationCatalogue,
		ObjectManagerInterface $objectManager
	) {
		$this->translationCatalogue = (string) $translationCatalogue;
		$this->objectManager = $objectManager;
	}

	/**
	 * Creates and returns a FlashMessage
	 *
	 * @param string $messageKey The message key within the localization file
	 * @param int $severity Severity
	 *
	 * @return FlashMessage
	 */
	public function create($messageKey, $severity = AbstractMessage::INFO) {
		return $this->objectManager->get(
			FlashMessage::class,
			LocalizationUtility::translate($this->translationCatalogue . ':' . $messageKey, 'vantomas'),
			'',
			$severity,
			TRUE
		);
	}
}
