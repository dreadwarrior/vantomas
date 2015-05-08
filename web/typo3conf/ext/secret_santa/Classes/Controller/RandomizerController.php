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

use DreadLabs\SecretSanta\Domain\Repository\PairRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use DreadLabs\SecretSanta\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Randomizer
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class RandomizerController extends ActionController {

	/**
	 * FrontendUserRepository
	 *
	 * @var \DreadLabs\SecretSanta\Domain\Repository\FrontendUserRepository
	 */
	protected $userRepository;

	/**
	 * PairRepository
	 *
	 * @var PairRepository
	 */
	protected $pairRepository;

	/**
	 * FrontendUserAuthentication
	 *
	 * @var FrontendUserAuthentication
	 */
	protected $frontendUser;

	/**
	 * Injects the frontend user repository
	 *
	 * @param FrontendUserRepository $userRepository FrontendUserRepository
	 *
	 * @return void
	 */
	public function injectFrontendUserRepository(FrontendUserRepository $userRepository) {
		$this->userRepository = $userRepository;
	}

	/**
	 * Injects the pair repo
	 *
	 * @param PairRepository $pairRepository PairRepository
	 *
	 * @return void
	 */
	public function injectPairRepository(PairRepository $pairRepository) {
		$this->pairRepository = $pairRepository;
	}

	/**
	 * Initializes all actions of this controller
	 *
	 * @return void
	 * @see \TYPO3\CMS\Extbase\Mvc\Controller\ActionController::initializeAction()
	 */
	public function initializeAction() {
		/* @var $fe TypoScriptFrontendController */
		$fe = $GLOBALS['TSFE'];
		$this->frontendUser = $fe->fe_user;
	}

	/**
	 * Randomizes a donor/donee pair
	 *
	 * @return void
	 */
	public function randomizeAction() {
		$this->settings['storagePid'] = $this->configurationManager
			->getContentObject()
			->data['pages'];

		$donor = $this->userRepository->findDonor(
			$this->frontendUser->user['uid']
		);

		$pair = $this->pairRepository->findPairFor($donor);

		if (is_null($pair)) {
			$donee = $this->userRepository->findDoneeFor(
				$this->pairRepository,
				$donor,
				$this->settings['storagePid']
			);
		} else {
			$donee = $pair->getDonee();
		}

		$this->view->assign('donee', $donee);
	}
}
