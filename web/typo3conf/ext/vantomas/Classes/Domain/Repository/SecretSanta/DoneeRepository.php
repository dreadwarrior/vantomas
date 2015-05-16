<?php
namespace DreadLabs\Vantomas\Domain\Repository\SecretSanta;

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

use DreadLabs\Vantomas\Domain\SecretSanta\Donee\DoneeInterface;
use DreadLabs\Vantomas\Domain\SecretSanta\Donee\RepositoryInterface;
use DreadLabs\Vantomas\Domain\SecretSanta\Donor\DonorInterface;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;

/**
 * DoneeRepository
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class DoneeRepository extends FrontendUserRepository implements RepositoryInterface {

	/**
	 * Tries to find a non-mutual donee for the given donor
	 *
	 * @param DonorInterface $donor The Donor
	 *
	 * @return DoneeInterface
	 */
	public function findOneNonMutualFor(DonorInterface $donor) {
		$query = $this->createQuery();

		$sqlString = '
			SELECT
				fe_users.*
			FROM
				fe_users
				LEFT JOIN tx_vantomas_domain_model_secretsanta_pair
					ON fe_users.uid = tx_vantomas_domain_model_secretsanta_pair.donee
			WHERE
				tx_vantomas_domain_model_secretsanta_pair.donee IS NULL
				AND fe_users.uid != ' . $donor->getUid() . '
			ORDER BY
				RAND()
			LIMIT 1;
		';

		$query->statement($sqlString);

		return $query->execute()->getFirst();
	}

	/**
	 * Finds a donee at random
	 *
	 * Needs the donor to build the exclude statement of the query.
	 *
	 * @param DonorInterface $donor The Donor to exclude by query
	 *
	 * @return DoneeInterface
	 */
	public function findOneAtRandomFor(DonorInterface $donor) {
		$query = $this->createQuery();

		$query->matching(
			$query->logicalNot(
				$query->equals('uid', $donor->getUid())
			)
		);

		return $query->execute()->getFirst();
	}
}
