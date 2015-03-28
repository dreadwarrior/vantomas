<?php
namespace DreadLabs\Vantomas\Utility;

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

use TYPO3\CMS\Backend\Sprite\SpriteManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provides access to \TYPO3\CMS\Core\Utility\ExtensionManagementUtility methods
 *
 * The target of the existence of this class to provide readability to the
 * ext_localconf & ext_tables scripts in the extension root directory.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ExtensionManagement implements SingletonInterface {

	/**
	 * @var int
	 */
	private static $blogArticleTypeId = 30;


	/**
	 * A utility method which calls ExtensionManagementUtility::addPiFlexFormValue
	 *
	 * This method performs the necessary string manipulations which are necessary
	 * for extbase based extensions.
	 *
	 * @param string $extensionKey mostly $_EXTKEY
	 * @param string $pluginName same value which is passed into
	 *                           Tx_Extbase_Utility_Extension::registerPlugin() as a
	 *                           second value
	 * @param string $flexformFile last part of the flexform file
	 *                             without leading slash
	 * @return void
	 * @api
	 */
	public static function addPluginFlexform($extensionKey, $pluginName, $flexformFile) {
		$extensionName = GeneralUtility::underscoredToUpperCamelCase($extensionKey);
		$pluginSignature = strtolower($extensionName . '_' . $pluginName);

		$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

		ExtensionManagementUtility::addPiFlexFormValue(
			$pluginSignature,
			self::getFlexformFileReference($extensionKey, $flexformFile)
		);
	}

	/**
	 * @param string $extensionKey
	 * @param string $flexformFile
	 * @return string
	 */
	private static function getFlexformFileReference($extensionKey, $flexformFile) {
		$replacePairs = array(
			'%{extensionKey}' => $extensionKey,
			'%{flexformBasePath}' => self::getFlexformFileBasePath(),
			'%{flexformFile}' => $flexformFile
		);

		return strtr(
			self::getFlexformFileReferencePattern(),
			$replacePairs
		);
	}

	/**
	 * @return string
	 */
	private static function getFlexformFileReferencePattern() {
		return 'FILE:EXT:%{extensionKey}%{flexformBasePath}%{flexformFile}';
	}

	/**
	 * @return string
	 */
	private static function getFlexformFileBasePath() {
		return '/Configuration/Flexform/';
	}

	/**
	 * @return void
	 */
	public static function registerBlogArticlePageType() {
		$image = '/Resources/Public/Images/doktype-blog-article.png';
		$icon = ExtensionManagementUtility::extRelPath('vantomas') . $image;

		$GLOBALS['PAGE_TYPES'][self::$blogArticleTypeId] = array(
			'type' => 'sys',
			'icon' => $icon,
			'allowedTables' => '*',
		);

		$GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = array(
			'LLL:EXT:vantomas/Resources/Private/Language/locallang.xlf:pages.doktype.blog_article',
			self::$blogArticleTypeId,
			$icon
		);

		$GLOBALS['TCA']['pages_language_overlay']['columns']['doktype']['config']['items'][] = array(
			'LLL:EXT:vantomas/Resources/Private/Language/locallang.xlf:pages.doktype.blog_article',
			self::$blogArticleTypeId,
			$icon
		);

		SpriteManager::addTcaTypeIcon('pages', self::$blogArticleTypeId, $icon);

		ExtensionManagementUtility::addUserTSConfig(
			'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . self::$blogArticleTypeId . ')'
		);
	}
}