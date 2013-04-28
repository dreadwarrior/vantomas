<?php
namespace Dreadwarrior\Vantomas\ViewHelpers\Request;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (tommy@van-tomas.de)
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

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * IsAjaxViewHelper renders a boolean value depending on HTTP_HOST or HTTP_X_REQUESTED_WITH server variable
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class IsAjaxViewHelper extends AbstractViewHelper {

	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('expectedHost', 'string', 'The expected host string', TRUE);
		$this->registerArgument('expectedXRequestedWith', 'string', 'The expected X-Requested-With header string', TRUE);
		$this->registerArgument('negate', 'boolean', 'Negates the return value', FALSE, FALSE);
	}

	/**
	 *
	 * @return boolean
	 */
	public function render() {
		$isAjaxRequest = $this->isAjaxRequest();

		if ($this->arguments['negate']) {
			return !$isAjaxRequest;
		} else {
			return $isAjaxRequest;
		}
	}

	private function isAjaxRequest() {
		$isExpectedHost = $this->isExpectedHost();
		$isExpectedXRequestedWith = $this->isExpectedXRequestedWith();

		return $isExpectedHost && $isExpectedXRequestedWith;
	}

	private function isExpectedHost() {
		$currentHost = GeneralUtility::getIndpEnv('HTTP_HOST');
		$isExpectedHost = $this->arguments['expectedHost'] === $currentHost;

		return $isExpectedHost;
	}

	private function isExpectedXRequestedWith() {
		$currentXRequestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'];
		$isExpectedXRequestedWith = $this->arguments['expectedXRequestedWith'] === $currentXRequestedWith;

		return $isExpectedXRequestedWith;
	}
}
?>
