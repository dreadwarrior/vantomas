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

use TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException;

/**
 * AccessControlController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class AccessControlController extends AbstractController {

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
	 * @throws UnsupportedRequestTypeException If not in web context
	 */
	public function loginAction() {
		$this->guardLogin($this->flashMessageFactory->createError('login.failed'), 'form');

		$this->redirect('show', 'SecretSanta\\RevealDonee');
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
