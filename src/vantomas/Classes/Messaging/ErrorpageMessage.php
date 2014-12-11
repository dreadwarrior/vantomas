<?php
namespace DreadLabs\Vantomas\Messaging;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Thomas Juhnke <typo3@van-tomas.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Provides a error page message object.
 *
 * @category \DreadLabs\Vantomas\Messaging
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class ErrorpageMessage extends \TYPO3\CMS\Core\Messaging\AbstractStandaloneMessage {

	/**
	 * Constructor for an Error message
	 *
	 * @param string $message The error message
	 * @param string $title Title of the message, can be empty
	 * @param integer $severity Optional severity, must be either of AbstractMessage::INFO or related constants
	 */
	public function __construct($message = '', $title = '', $severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR) {
		$this->htmlTemplate =ExtensionManagementUtility::extPath(
			'vantomas',
			'Resources/Private/Templates/Page/ErrorPage.html'
		);

		parent::__construct($message, $title, $severity);
	}
}