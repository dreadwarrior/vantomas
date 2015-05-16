<?php
namespace DreadLabs\Vantomas\Domain\User;

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

use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * FrontendUserId
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FrontendUserId extends AbstractUserId {

	/**
	 * Named constructor
	 *
	 * The UserId VO is build from the logged in user information found
	 * via TSFE->fe_user->user.
	 *
	 * @return static
	 */
	public static function fromLoggedInUser() {
		return new static(self::getFrontendUser()->user['uid']);
	}

	/**
	 * Returns a frontend user authentication instance
	 *
	 * @return FrontendUserAuthentication
	 */
	private static function getFrontendUser() {
		return self::getTypoScriptFrontendController()->fe_user;
	}

	/**
	 * Returns a TSFE instance
	 *
	 * @return TypoScriptFrontendController
	 */
	private static function getTypoScriptFrontendController() {
		return $GLOBALS['TSFE'];
	}
}
