<?php
namespace DreadLabs\SecretSanta\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2014 Thomas Juhnke <typo3@van-tomas.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Registers NewContentElement wizard icons for the extension
 *
 * @package \DreadLabs\SecretSanta\Hooks
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class NewContentElementWizardIconHook {

	/**
	 * Processes the wizard items array by adding or plugin(s) to the wizard
	 *
	 * @param array $wizardItems The wizard items so far
	 * @return array Modified array with (new) wizard items
	 */
	public function proc($wizardItems) {
		$LL = $this->includeLocalLang();

		$wizardItems['plugins_secretsanta_randomizer'] = array(
			'icon' => ExtensionManagementUtility::extRelPath('secret_santa') . 'Resources/Public/Icons/RandomizerWizardIcon.gif',
			'title' => $GLOBALS['LANG']->getLLL('plugin.randomizer.title', $LL),
			'description' => $GLOBALS['LANG']->getLLL('plugin.randomizer.description', $LL),
			'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=secretsanta_randomizer'
		);

		return $wizardItems;
	}

	/**
	 * Reads a l10n catalogue and returns the translations for local usage
	 *
	 * @return array The array with language labels
	 */
	protected function includeLocalLang()	{
		$llFile = ExtensionManagementUtility::extPath('secret_santa') . 'Resources/Private/Language/locallang_db.xlf';
		$LOCAL_LANG = GeneralUtility::readLLfile(
			$llFile,
			$GLOBALS['LANG']->lang
		);

		return $LOCAL_LANG;
	}
}
?>