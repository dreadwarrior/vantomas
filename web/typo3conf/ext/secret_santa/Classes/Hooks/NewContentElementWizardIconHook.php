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
		$localLang = $this->includeLocalLang();

		$wizardItems['plugins_secretsanta_randomizer'] = array(
			'icon' => ExtensionManagementUtility::extRelPath('secret_santa') . 'Resources/Public/Icons/RandomizerWizardIcon.gif',
			'title' => $GLOBALS['LANG']->getLLL('plugin.randomizer.title', $localLang),
			'description' => $GLOBALS['LANG']->getLLL('plugin.randomizer.description', $localLang),
			'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=secretsanta_randomizer'
		);

		return $wizardItems;
	}

	/**
	 * Reads a l10n catalogue and returns the translations for local usage
	 *
	 * @return array The array with language labels
	 */
	protected function includeLocalLang() {
		$llFile = ExtensionManagementUtility::extPath('secret_santa') . 'Resources/Private/Language/locallang_db.xlf';
		$localLang = GeneralUtility::readLLfile(
			$llFile,
			$GLOBALS['LANG']->lang
		);

		return $localLang;
	}
}