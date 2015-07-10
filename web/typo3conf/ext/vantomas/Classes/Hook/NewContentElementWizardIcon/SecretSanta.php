<?php
namespace DreadLabs\Vantomas\Hook\NewContentElementWizardIcon;

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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;

/**
 * Registers NewContentElement wizard icons for the extension
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SecretSanta {

	/**
	 * Array of language labels
	 *
	 * @var array
	 */
	private $languageLabels = array();

	/**
	 * The items for the new content element wizard
	 *
	 * @var array
	 */
	private $wizardItems = array();

	/**
	 * Processes the wizard items array by adding or plugin(s) to the wizard
	 *
	 * @param array $wizardItems The wizard items so far
	 *
	 * @return array Modified array with (new) wizard items
	 */
	public function proc(array $wizardItems) {
		$this->loadLanguageLabels();

		$this->wizardItems = $wizardItems;
		$this->wizardItems['plugins_vantomas_secretsanta'] = array(
			'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=vantomas_secretsanta',
		);

		$this->addIcon();
		$this->addTitle();
		$this->addDescription();

		return $this->wizardItems;
	}

	/**
	 * Reads a l10n catalogue and returns the translations for local usage
	 *
	 * @return void
	 */
	protected function loadLanguageLabels() {
		$languageFilePath = 'Resources/Private/Language/locallang_db.xlf';
		$languageFile = ExtensionManagementUtility::extPath('vantomas') . $languageFilePath;
		$this->languageLabels = GeneralUtility::readLLfile(
			$languageFile,
			$this->getLanguageService()->lang
		);
	}

	/**
	 * Returns the backend language service
	 *
	 * @return LanguageService
	 */
	private function getLanguageService() {
		return $GLOBALS['LANG'];
	}

	/**
	 * Adds the icon for the wizard entry to the wizardItems array
	 *
	 * @return void
	 */
	private function addIcon() {
		$iconFile = 'Resources/Public/Icons/SecretSantaWizardIcon.png';
		$icon = ExtensionManagementUtility::extRelPath('vantomas') . $iconFile;
		$this->wizardItems['plugins_vantomas_secretsanta']['icon'] = $icon;
	}

	/**
	 * Adds the title for the wizard entry to the wizardItems array
	 *
	 * @return void
	 */
	private function addTitle() {
		$title = $this->getLanguageService()->getLLL('plugin.secretsanta.title', $this->languageLabels);
		$this->wizardItems['plugins_vantomas_secretsanta']['title'] = $title;
	}

	/**
	 * Adds the description for the wizard entry to the wizardItems array
	 *
	 * @return void
	 */
	private function addDescription() {
		$description = $this->getLanguageService()->getLLL('plugin.secretsanta.description', $this->languageLabels);
		$this->wizardItems['plugins_vantomas_secretsanta']['description'] = $description;
	}

	/**
	 * Self-registers the icon
	 *
	 * @param string $extensionKey The extension key
	 *
	 * @return void
	 */
	public static function register($extensionKey) {
		$icon = ExtensionManagementUtility::extPath(
			$extensionKey,
			'Classes/Hook/NewContentElementWizardIcon/SecretSanta.php'
		);
		$GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses'][self::class] = $icon;
	}
}
