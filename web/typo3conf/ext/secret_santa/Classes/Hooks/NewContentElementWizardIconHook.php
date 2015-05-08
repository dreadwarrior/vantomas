<?php
namespace DreadLabs\SecretSanta\Hooks;

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
class NewContentElementWizardIconHook {

	/**
	 * Processes the wizard items array by adding or plugin(s) to the wizard
	 *
	 * @param array $wizardItems The wizard items so far
	 *
	 * @return array Modified array with (new) wizard items
	 */
	public function proc($wizardItems) {
		$languageLabels = $this->loadAndGetLanguageLabels();

		$wizardItems['plugins_secretsanta_randomizer'] = array(
			'icon' => ExtensionManagementUtility::extRelPath('secret_santa') . 'Resources/Public/Icons/RandomizerWizardIcon.gif',
			'title' => $this->getLanguageService()->getLLL('plugin.randomizer.title', $languageLabels),
			'description' => $this->getLanguageService()->getLLL('plugin.randomizer.description', $languageLabels),
			'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=secretsanta_randomizer'
		);

		return $wizardItems;
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
	 * Reads a l10n catalogue and returns the translations for local usage
	 *
	 * @return array The array with language labels
	 */
	protected function loadAndGetLanguageLabels() {
		$languageFilePath = 'Resources/Private/Language/locallang_db.xlf';
		$languageFile = ExtensionManagementUtility::extPath('secret_santa') . $languageFilePath;
		$languageLabels = GeneralUtility::readLLfile(
			$languageFile,
			$this->getLanguageService()->lang
		);

		return $languageLabels;
	}
}
