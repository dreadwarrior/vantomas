<?php
namespace DreadLabs\Vantomas\Domain\SecretSanta\AccessControl;

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

use DreadLabs\VantomasWebsite\SecretSanta\AccessControl\GuardInterface;
use DreadLabs\VantomasWebsite\SecretSanta\AccessControl\UnauthenticatedException;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * FrontendGuard
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FrontendGuard implements GuardInterface {

	/**
	 * TypoScriptFrontendController
	 *
	 * @var TypoScriptFrontendController
	 */
	private $typoScriptFrontendController;

	/**
	 * Initializes the Guard instance
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->typoScriptFrontendController = $GLOBALS['TSFE'];
	}

	/**
	 * Flags if the current request has an authenticated user
	 *
	 * @return void
	 *
	 * @throws UnauthenticatedException If frontend has no authenticated user
	 */
	public function assertAuthenticatedUser() {
		if (!$this->typoScriptFrontendController->loginUser) {
			throw new UnauthenticatedException('Authenticated user assertion failed.', 1438720678);
		}
	}
}