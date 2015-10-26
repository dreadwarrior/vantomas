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
	 * Registers the page type
	 *
	 * @param string $extensionKey Extension key
	 * @param int $pageType Page type (doktype)
	 * @param string $iconFile Name of the icon file to use for the page type
	 * @param string $labelKey Label / title of the page type
	 *
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
	 * Returns a Resources/Public/Images path for the given filename
	 *
	 * @param string $extensionKey Extension key
	 * @param string $fileName Name of the image file
	 *
	 * @return string
	 */
	private static function getRelativePublicImagePath($extensionKey, $fileName) {
		$filePath = 'Resources/Public/Images/' . $fileName;
		return ExtensionManagementUtility::extRelPath($extensionKey) . $filePath;
	}

	/**
	 * Registers the page type in the TCA
	 *
	 * @param string $icon Icon path and file name
	 * @param string $label Label for the page type
	 * @param int $pageType Page type
	 *
	 * @return void
	 */
	private static function registerPageTypeInTca($icon, $label, $pageType) {
		foreach (array('pages', 'pages_language_overlay') as $table) {
			$GLOBALS['TCA'][$table]['columns']['doktype']['config']['items'][] = array(
				$label,
				$pageType,
				'tcarecords-' . $table . '-' . $pageType
			);
			SpriteManager::addTcaTypeIcon($table, $pageType, $icon);
		}
	}

	/**
	 * Registers the page type in the PageTree drag area
	 *
	 * @param int $pageType Page type
	 *
	 * @return void
	 */
	private static function registerTypeInPageTreeDragArea($pageType) {
		ExtensionManagementUtility::addUserTSConfig(
			'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $pageType . ')'
		);
	}
}
