<?php
namespace DreadLabs\SecretSanta\Domain\Pair;

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

use DreadLabs\SecretSanta\Domain\Model\FrontendUser;
use DreadLabs\SecretSanta\Domain\Model\Pair;
use DreadLabs\SecretSanta\Domain\Repository\FrontendUserRepository;
use DreadLabs\SecretSanta\Domain\Repository\PairRepository;
use DreadLabs\SecretSanta\Domain\User\UserIdInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * PairResolver
 *
 * @author Thomas Juhnke <typo@van-tomas.de>
 */
class PairResolver implements PairResolverInterface {

	/**
	 * Amount of maximum mutual loops
	 *
	 * @var int
	 */
	const MAX_MUTUAL_LOOP = 1000;

	/**
	 * DI ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * FrontendUserRepository
	 *
	 * @var FrontendUserRepository
	 */
	private $userRepository;

	/**
	 * PairRepository
	 *
	 * @var PairRepository
	 */
	private $pairRepository;

	/**
	 * Constructor
	 *
	 * @param ObjectManagerInterface $objectManager DI ObjectManager
	 * @param FrontendUserRepository $userRepository FrontendUserRepository
	 * @param PairRepository $pairRepository PairRepository
	 */
	public function __construct(
		ObjectManagerInterface $objectManager,
		FrontendUserRepository $userRepository,
		PairRepository $pairRepository
	) {
		$this->objectManager = $objectManager;
		$this->userRepository = $userRepository;
		$this->pairRepository = $pairRepository;
	}

	/**
	 * Resolves a donee for the incoming donor user id
	 *
	 * @param UserIdInterface $userId User id of the donor
	 *
	 * @return FrontendUser A donee
	 */
	public function resolveDoneeFor(UserIdInterface $userId) {
		$donor = $this->userRepository->findDonor($userId->getValue());

		$pair = $this->pairRepository->findPairFor($donor);

		if (!is_null($pair)) {
			return $pair->getDonee();
		}

		$donee = $this->findNewDoneeFor($donor);

		$this->persistPair($donor, $donee);

		return $donee;
	}

	/**
	 * Finds a new donee for the given donor
	 *
	 * @param FrontendUser $donor FrontendUser donor
	 *
	 * @return FrontendUser
	 */
	private function findNewDoneeFor(FrontendUser $donor) {
		$mutualIncrementor = 0;

		do {
			$donee = $this->userRepository->findPossibleDoneeFor($donor);

			$mutualIncrementor++;
		} while (
			$this->pairRepository->isPairMutually(
				$donor,
				$donee
			)
			&& $mutualIncrementor < self::MAX_MUTUAL_LOOP
		);

		// if no possible pairing could be determined
		if (!$donee instanceof FrontendUser) {
			$donee = $this->userRepository->findOneRandomDonee($donor);
		}

		return $donee;
	}

	/**
	 * Persists a given donor/donee Pair
	 *
	 * @param FrontendUser $donor Donor
	 * @param FrontendUser $donee Donee
	 *
	 * @return void
	 */
	private function persistPair(FrontendUser $donor, FrontendUser $donee) {
		/* @var $pair Pair */
		$pair = $this->objectManager->get(Pair::class);
		$pair->setDonor($donor);
		$pair->setDonee($donee);

		$this->pairRepository->add($pair);
	}
}
