<?php
namespace DreadLabs\Vantomas\Utility\ExtensionManagement;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Thomas Juhnke (typo3@van-tomas.de)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * ExtensionManagement utility for RTE on pages.abstract
 *
 * @package DreadLabs\Vantomas\Utility\ExtensionManagement
 */
class PageAbstractRte implements SingletonInterface {

	/**
	 * @var array
	 */
	private static $configuration = array();

	/**
	 * @param array $configuration
	 * @return void
	 */
	public static function configure(array $configuration) {
		try {
			self::$configuration = ArrayUtility::getValueByPath(
				$configuration,
				'pages./abstract./rte.'
			);

			self::disableGlobally();
			self::setVisibleButtons();
			self::setHiddenButtons();
		} catch (\Exception $e) {
		}
	}

	/**
	 * Disables the RTE for the pages.abstract field globally
	 *
	 * @return void
	 */
	private static function disableGlobally() {
		if ((bool) self::$configuration['disableGlobally']) {
			ExtensionManagementUtility::addPageTSConfig('
				RTE.config.pages.abstract.disabled = 1
			');
		}
	}

	/**
	 * Sets the visible buttons for the RTE on pages.abstract
	 *
	 * @return void
	 */
	private static function setVisibleButtons() {
		$visibleButtons = trim(self::$configuration['showButtons']);

		if ($visibleButtons != '') {
			ExtensionManagementUtility::addPageTSConfig('
				RTE.config.pages.abstract.showButtons = ' . $visibleButtons . '
			');
		}
	}

	/**
	 * Sets the buttons to hide for the RTE on pages.abstract
	 *
	 * @return void
	 */
	private static function setHiddenButtons() {
		$hiddenButtons = trim(self::$configuration['hideButtons']);

		if ($hiddenButtons != '') {
			ExtensionManagementUtility::addPageTSConfig('
				RTE.config.pages.abstract.hideButtons = ' . $hiddenButtons . '
			');
		}
	}
}