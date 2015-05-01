<?php
namespace DreadLabs\Vantomas\Utility;

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
}
