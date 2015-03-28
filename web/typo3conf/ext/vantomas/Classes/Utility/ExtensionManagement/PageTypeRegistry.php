<?php
namespace DreadLabs\Vantomas\Utility\ExtensionManagement;

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Thomas Juhnke (typo3@van-tomas.de)
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

use TYPO3\CMS\Backend\Sprite\SpriteManager;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class PageTypeRegistry {

	/**
	 * @param string $extensionKey
	 * @param int $pageType
	 * @param string $iconFile
	 * @param string $labelKey
	 * @return void
	 */
	public static function registerPageType($extensionKey, $pageType, $iconFile, $labelKey) {
		$icon = self::getRelativePublicImagePath($extensionKey, $iconFile);
		$label = sprintf('LLL:EXT:%s/Resources/Private/Language/locallang.xlf:%s', $extensionKey, $labelKey);

		$GLOBALS['PAGE_TYPES'][$pageType] = array(
			'type' => 'sys',
			'icon' => $icon,
			'allowedTables' => '*',
		);

		self::registerPageTypeInTca($icon, $label, $pageType);
		self::registerTypeInPageTreeDragArea($pageType);
	}

	/**
	 * @param string $extensionKey
	 * @param string $fileName
	 * @return string
	 */
	private static function getRelativePublicImagePath($extensionKey, $fileName) {
		$filePath = '/Resources/Public/Images/' . $fileName;
		return ExtensionManagementUtility::extRelPath($extensionKey) . $filePath;
	}

	/**
	 * @param string $icon
	 * @param string $label
	 * @param int $pageType
	 * @return void
	 */
	private static function registerPageTypeInTca($icon, $label, $pageType) {
		foreach (array('pages', 'pages_language_overlay') as $table) {
			$GLOBALS['TCA'][$table]['columns']['doktype']['config']['items'][] = array(
				$label,
				$pageType,
				$icon
			);
			SpriteManager::addTcaTypeIcon($table, $pageType, $icon);
		}
	}

	/**
	 * @param int $pageType
	 * @return void
	 */
	private static function registerTypeInPageTreeDragArea($pageType) {
		ExtensionManagementUtility::addUserTSConfig(
			'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $pageType . ')'
		);
	}
}