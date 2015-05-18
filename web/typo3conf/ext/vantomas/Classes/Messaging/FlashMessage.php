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
 * FlashMessage
 *
 * A custom flash message renderer which renders the classes for the message
 * boxes according to the alert-boxes component of the zurb foundation css
 * framework.
 *
 * Thanks @ Sven Burkert, for more information see:
 * http://blog.sbtheke.de/web-development/typo3/typo3-extension-programmierung/extbase-flashmessages
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FlashMessage extends \TYPO3\CMS\Core\Messaging\FlashMessage {

	/**
	 * The message severity class names
	 *
	 * @var array
	 */
	protected $classes = array(
		self::NOTICE => 'info radius',
		self::INFO => 'info radius',
		self::OK => 'success radius',
		self::WARNING => 'warning radius',
		self::ERROR => 'alert radius'
	);

	/**
	 * Gets the message severity class name
	 *
	 * @return string The message severity class name
	 */
	public function getClass() {
		return $this->classes[$this->severity];
	}

	/**
	 * Renders the flash message.
	 *
	 * @return string The flash message as HTML.
	 */
	public function render() {
		$title = '';

		if (!empty($this->title)) {
			$title = '<h4>' . $this->title . '</h4>';
		}

		$message = '<div class="alert-box ' . $this->getClass() . '">' . $title . '<div class="alert-body">' . $this->message . '</div>' . '</div>';

		return $message;
	}
}
