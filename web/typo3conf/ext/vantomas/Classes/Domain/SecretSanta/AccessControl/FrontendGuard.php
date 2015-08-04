<?php
namespace DreadLabs\Vantomas\Domain\SecretSanta\AccessControl;

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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