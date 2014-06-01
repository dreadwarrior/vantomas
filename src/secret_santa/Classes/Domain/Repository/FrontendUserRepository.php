<?php
namespace DreadLabs\SecretSanta\Domain\Repository;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Thomas Juhnke <typo3@van-tomas.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\SecretSanta\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * FrontendUserRepository
 *
 * @package \DreadLabs\SecretSanta\Domain\Repository
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class FrontendUserRepository extends \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository {

	/**
	 *
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * Injects the object manager
	 *
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 *
	 * @param integer $donorUid
	 * @return FrontendUser
	 */
	public function findDonor($donorUid) {
		return $this->findByUid($donorUid);
	}

	/**
	 * Tries to find a donee $donor
	 *
	 * @param PairRepository $pairRepository
	 * @param FrontendUser $donor
	 * @param integer $storagePid
	 * @return FrontendUser
	 */
	public function findDoneeFor(
		PairRepository $pairRepository,
		FrontendUser $donor,
		$storagePid
	) {
		$donee = $this->findPossibleDoneeFor(
			$donor,
			$storagePid
		);

		$i = 0;

		while (
			$pairRepository->isPairMutually(
				$donor,
				$donee
			)
			&& $i < PairRepository::MAX_MUTUAL_LOOP
		) {
			$donee = $this->findPossibleDoneeFor(
				$donor,
				$storagePid
			);

			$i++;
		}

		// if no possible pairing could be determined
		if (!$donee instanceof FrontendUser) {
			$donee = $this->findOneDoneeRandomized($donor, $storagePid);
		}

		/* @var $pair \DreadLabs\SecretSanta\Domain\Model\Pair */
		$pair = $this->objectManager->get('DreadLabs\\SecretSanta\\Domain\\Model\\Pair');
		$pair->setDonor($donor);
		$pair->setDonee($donee);
		$pair->setPid($storagePid);

		$pairRepository->add($pair);

		return $donee;
	}

	/**
	 * Tries to find a possible donee for $donor
	 *
	 * @param FrontendUser $donor
	 * @param integer $storagePid
	 * @return Participant
	 */
	public function findPossibleDoneeFor(FrontendUser $donor, $storagePid) {
		$query = $this->createQuery();

		$sqlString = '
			SELECT
				fe_users.*
			FROM
				fe_users
				LEFT JOIN tx_secretsanta_domain_model_pair
					on fe_users.uid = tx_secretsanta_domain_model_pair.donee
			WHERE
				tx_secretsanta_domain_model_pair.donee IS NULL
				AND fe_users.pid = ?
				AND fe_users.uid != ?
			ORDER BY
				RAND()
			LIMIT 1;
		';

		$queryParameters = array(
			$storagePid,
			$donor->getUid()
		);

		$query->statement($sqlString, $queryParameters);

		return $query->execute()->getFirst();
	}

	/**
	 *
	 * @param FrontendUser $donor
	 * @param integer $storagePid
	 * @return FrontendUser
	 */
	public function findOneDoneeRandomized(FrontendUser $donor, $storagePid) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->logicalAnd(
				$query->equals('pid', $storagePid),
				$query->logicalNot(
					$query->equals('uid', $donor->getUid())
				)
			)
		);

		return $query->execute()->getFirst();
	}
}