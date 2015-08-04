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

use DreadLabs\Vantomas\Domain\User\FrontendUserId;
use DreadLabs\Vantomas\Messaging\FlashMessageFactoryInterface;
use DreadLabs\VantomasWebsite\SecretSanta\AccessControl\GuardInterface;
use DreadLabs\VantomasWebsite\SecretSanta\AccessControl\UnauthenticatedException;
use DreadLabs\VantomasWebsite\SecretSanta\Donee\ResolverInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * RevealDoneeController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class RevealDoneeController extends ActionController {

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
	 * Donee ResolverInterface
	 *
	 * @var ResolverInterface
	 */
	private $doneeResolver;

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
	 * Shows the donee to the logged in donor
	 *
	 * @return void
	 */
	public function showAction() {
		try {
			$this->guard->assertAuthenticatedUser();

			$donee = $this->doneeResolver->resolveFor(FrontendUserId::fromLoggedInUser());

			$this->view->assign('donee', $donee);
		} catch (UnauthenticatedException $exc) {
			$flashMessageQueue = $this->controllerContext->getFlashMessageQueue();
			$this->flashMessageFactory->createInfo('login.unauthorized')->enqueueIn($flashMessageQueue);

			$this->redirect('form', 'SecretSanta\\AccessControl');
		}
	}
}
