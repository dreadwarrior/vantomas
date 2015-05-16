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

use DreadLabs\Vantomas\Domain\SecretSanta\Donee\ResolverInterface;
use DreadLabs\Vantomas\Domain\User\FrontendUserId;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

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
	 * Shows the donee to the logged in donor
	 *
	 * @return void
	 */
	public function showAction() {
		$donee = $this->doneeResolver->resolveFor(
			FrontendUserId::fromLoggedInUser()
		);

		$this->view->assign('donee', $donee);
	}
}
