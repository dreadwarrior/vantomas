<?php
namespace DreadLabs\SecretSanta\Controller;

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

use DreadLabs\SecretSanta\Domain\Donee\ResolverInterface;
use DreadLabs\SecretSanta\Domain\User\FrontendUserId;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Randomizer
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class RandomizerController extends ActionController {

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
	 * Randomizes a donor/donee pair
	 *
	 * @return void
	 */
	public function randomizeAction() {
		$donee = $this->doneeResolver->resolveFor(
			FrontendUserId::fromLoggedInUser()
		);

		$this->view->assign('donee', $donee);
	}
}
