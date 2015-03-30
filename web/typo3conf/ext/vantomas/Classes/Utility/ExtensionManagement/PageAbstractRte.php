<?php
namespace DreadLabs\Vantomas\Utility\ExtensionManagement;

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

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * ExtensionManagement utility for RTE on pages.abstract
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
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