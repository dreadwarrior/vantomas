<?php
namespace DreadLabs\Vantomas\Controller;

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

use DreadLabs\Vantomas\Messaging\FlashMessageFactory;
use DreadLabs\VantomasWebsite\SecretSanta\Donee\ResolverInterface;
use DreadLabs\Vantomas\Domain\User\FrontendUserId;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * SecretSantaController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SecretSantaController extends ActionController {

	/**
	 * Donee ResolverInterface
	 *
	 * @var ResolverInterface
	 */
	private $doneeResolver;

	/**
	 * FlashMessage factory
	 *
	 * @var FlashMessageFactory
	 */
	private $flashMessageFactory;

	/**
	 * Injects the donee resolver
	 *
	 * @param ResolverInterface $doneeResolver Donee resolver
	 *
	 * @return void
	 */
	public function injectDoneeResolver(ResolverInterface $doneeResolver) {
		$this->doneeResolver = $doneeResolver;
	}

	/**
	 * Initializes the view
	 *
	 * @return void
	 */
	public function initializeView() {
		$usersStoragePageId = (int) $this->configurationManager->getContentObject()->data['pages'];
		$this->view->assign('usersStoragePageId', $usersStoragePageId);

		$this->flashMessageFactory = $this->objectManager->get(
			FlashMessageFactory::class,
			'LLL:EXT:vantomas/Resources/Private/Language/SecretSanta/locallang.xlf'
		);
	}

	/**
	 * Shows the login form
	 *
	 * @return void
	 */
	public function loginFormAction() {
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
		if (!$this->getTypoScriptFrontendController()->loginUser) {
			$this->controllerContext->getFlashMessageQueue()->enqueue(
				$this->flashMessageFactory->create('login.failed', AbstractMessage::ERROR)
			);
			$this->redirect('loginForm');
		}

		$this->redirect('show');
	}

	/**
	 * Returns the TSFE instance
	 *
	 * @return TypoScriptFrontendController
	 */
	private function getTypoScriptFrontendController() {
		return $GLOBALS['TSFE'];
	}

	/**
	 * Shows the donee to the logged in donor
	 *
	 * @return void
	 */
	public function showAction() {
		if (!$this->getTypoScriptFrontendController()->loginUser) {
			$this->controllerContext->getFlashMessageQueue()->enqueue(
				$this->flashMessageFactory->create('login.unauthorized', AbstractMessage::INFO)
			);
			$this->redirect('loginForm');
		}

		$donee = $this->doneeResolver->resolveFor(
			FrontendUserId::fromLoggedInUser()
		);

		$this->view->assign('donee', $donee);
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
		$this->redirect('loginForm');
	}
}
