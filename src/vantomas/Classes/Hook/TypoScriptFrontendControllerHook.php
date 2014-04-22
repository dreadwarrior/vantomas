<?php
namespace DreadLabs\Vantomas\Hook;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (typo3@van-tomas.de)
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

/**
 * Hook class for TypoScriptFrontendController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TypoScriptFrontendControllerHook implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * Replacement for static subdomain/CDN ressources
	 * 
	 * Hooks into `tslib/class.tslib_fe.php::contentPostProc-all`.
	 *
	 * @param $parameters Only contains one item: `pObj` which is a reference to $parentObject
	 * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController &$parentObject
	 */
	public function interceptCdnReplacements($parameters = array(), \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController &$parentObject) {
		$this->config = $parentObject->config['config']['cdn.'];

		$search = $this->config['search.'];

		$replace = $this->config['replace.']['http.'];

		// @todo: check if this is working if TYPO3 itself is not in SSL mode, but a reverse proxy is...
		if (\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SSL')) {
			$replace = $this->config['replace.']['https.'];
		}

		$parentObject->content = str_replace(
			$search,
			$replace,
			$parentObject->content
		);
	}
}
?>