<?php
namespace DreadLabs\SecretSanta\Domain\Repository;

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
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * FrontendUserRepository
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FrontendUserRepository extends \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository {

	/**
	 * DI ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * Injects the object manager
	 *
	 * @param ObjectManagerInterface $objectManager DI ObjectManager
	 *
	 * @return void
	 */
	public function injectObjectManager(ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Finds a donor
	 *
	 * @param int $donorUid Donor UID
	 *
	 * @return FrontendUser
	 */
	public function findDonor($donorUid) {
		return $this->findByUid($donorUid);
	}

	/**
	 * Tries to find a donee $donor
	 *
	 * @param PairRepository $pairRepository PairRepository
	 * @param FrontendUser $donor FrontendUser
	 *
	 * @return FrontendUser
	 */
	public function findDoneeFor(
		PairRepository $pairRepository,
		FrontendUser $donor
	) {
		$donee = $this->findPossibleDoneeFor($donor);

		$mutualIncrementor = 0;

		while (
			$pairRepository->isPairMutually(
				$donor,
				$donee
			)
			&& $mutualIncrementor < PairRepository::MAX_MUTUAL_LOOP
		) {
			$donee = $this->findPossibleDoneeFor($donor);

			$mutualIncrementor++;
		}

		// if no possible pairing could be determined
		if (!$donee instanceof FrontendUser) {
			$donee = $this->findOneRandomDonee($donor);
		}

		/* @var $pair Pair */
		$pair = $this->objectManager->get(Pair::class);
		$pair->setDonor($donor);
		$pair->setDonee($donee);

		$pairRepository->add($pair);

		return $donee;
	}

	/**
	 * Tries to find a possible donee for $donor
	 *
	 * @param FrontendUser $donor FrontendUser donor
	 *
	 * @return FrontendUser
	 */
	public function findPossibleDoneeFor(FrontendUser $donor) {
		$query = $this->createQuery();

		$sqlString = '
			SELECT
				fe_users.*
			FROM
				fe_users
				LEFT JOIN tx_secretsanta_domain_model_pair
					ON fe_users.uid = tx_secretsanta_domain_model_pair.donee
			WHERE
				tx_secretsanta_domain_model_pair.donee IS NULL
				AND fe_users.uid != ' . $donor->getUid() . '
			ORDER BY
				RAND()
			LIMIT 1;
		';

		$query->statement($sqlString);

		return $query->execute()->getFirst();
	}

	/**
	 * Finds a donee - randomly
	 *
	 * @param FrontendUser $donor FrontendUser donor
	 *
	 * @return FrontendUser
	 */
	public function findOneRandomDonee(FrontendUser $donor) {
		$query = $this->createQuery();

		$query->matching(
			$query->logicalNot(
				$query->equals('uid', $donor->getUid())
			)
		);

		return $query->execute()->getFirst();
	}
}
