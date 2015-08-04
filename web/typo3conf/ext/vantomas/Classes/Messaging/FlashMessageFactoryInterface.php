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

/**
 * FlashMessageFactoryInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface FlashMessageFactoryInterface {

	/**
	 * Sets necessary values for the LocalizationUtility
	 *
	 * @param string $extensionKey The extension key
	 * @param string $translationCatalogue The translation catalogue file reference
	 *
	 * @return void
	 */
	public function configureLocalizationUtility($extensionKey, $translationCatalogue);

	/**
	 * Creates and returns an error-level flash message
	 *
	 * @param string $messageKey The message key within the localization file
	 *
	 * @return FlashMessage
	 */
	public function createError($messageKey);

	/**
	 * Creates and returns an info-level flash message
	 *
	 * @param string $messageKey The message key within the localization file
	 *
	 * @return FlashMessage
	 */
	public function createInfo($messageKey);
}