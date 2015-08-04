<?php
namespace DreadLabs\Vantomas\Controller\SecretSanta;

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

use DreadLabs\Vantomas\Messaging\FlashMessageFactoryInterface;
use DreadLabs\VantomasWebsite\SecretSanta\AccessControl\GuardInterface;
use DreadLabs\VantomasWebsite\SecretSanta\AccessControl\UnauthenticatedException;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException;

/**
 * AccessControlController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class AccessControlController extends ActionController {

	/**
	 * AccessControl guard
	 *
	 * @var GuardInterface
	 */
	private $guard;

	/**
	 * FlashMessageFactory
	 *
	 * @var FlashMessageFactoryInterface
	 */
	private $flashMessageFactory;

	/**
	 * Injects the AccessControl guard
	 *
	 * @param GuardInterface $guard The AccessControl guard
	 *
	 * @return void
	 */
	public function injectGuard(GuardInterface $guard) {
		$this->guard = $guard;
	}

	/**
	 * Injects the FlashMessageFactory
	 *
	 * @param FlashMessageFactoryInterface $flashMessageFactory FlashMessage factory
	 *
	 * @return void
	 */
	public function injectFlashMessageFactory(FlashMessageFactoryInterface $flashMessageFactory) {
		$this->flashMessageFactory = $flashMessageFactory;
	}

	/**
	 * Initializes the actions
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->flashMessageFactory->configureLocalizationUtility(
			$this->request->getControllerExtensionKey(),
			'LLL:EXT:vantomas/Resources/Private/Language/SecretSanta/locallang.xlf'
		);
	}

	/**
	 * Shows the login form
	 *
	 * @return void
	 */
	public function formAction() {
	}

	/**
	 * Performs the login
	 *
	 * Basically, this only checks if `loginUser` in TSFE is TRUE. The authentication
	 * itself is handled by the TYPO3.CMS core which "listens" on submission of the
	 * user + pass POST parameters.
	 *
	 * @return void
	 *
	 * @throws UnsupportedRequestTypeException If not in web context
	 */
	public function loginAction() {
		try {
			$this->guard->assertAuthenticatedUser();

			$this->redirect('show', 'SecretSanta\\RevealDonee');
		} catch (UnauthenticatedException $exc) {
			$flashMessageQueue = $this->controllerContext->getFlashMessageQueue();
			$this->flashMessageFactory->createError('login.failed')->enqueueIn($flashMessageQueue);

			$this->redirect('form');
		}
	}

	/**
	 * Performs the logout action
	 *
	 * Basically, this redirects to the loginForm action. The logout is
	 * handled by the TYPO3.CMS core (loginType POST parameter).
	 *
	 * @return void
	 * @throws UnsupportedRequestTypeException If not in web context
	 */
	public function logoutAction() {
		$this->redirect('form');
	}

}
