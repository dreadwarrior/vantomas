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

use TYPO3\CMS\Backend\Sprite\SpriteManager;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Registers new page types (doktype in TYPO3.CMS)
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
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

		$GLOBALS['PAGES_TYPES'][$pageType] = array(
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
