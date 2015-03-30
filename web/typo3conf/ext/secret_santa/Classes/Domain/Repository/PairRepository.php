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
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The Pair repository
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PairRepository extends Repository {

	/**
	 * Amount of maximum mutual loops
	 *
	 * @var integer
	 */
	const MAX_MUTUAL_LOOP = 1000;

	/**
	 * Try to find a pair for the given $donor
	 *
	 * @param FrontendUser $donor
	 * @return NULL|Pair
	 */
	public function findPairFor(FrontendUser $donor) {
		$query = $this->createQuery();

		$query->matching(
			$query->equals('donor', $donor)
		);

		return $query->execute()->getFirst();
	}

	/**
	 * Checks if the pair is mutually
	 *
	 * @param FrontendUser $donor
	 * @param FrontendUser $donee
	 * @return boolean
	 */
	public function isPairMutually(
		FrontendUser $donor,
		FrontendUser $donee
	) {

		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->logicalAnd(
				$query->equals('donor', $donee),
				$query->equals('donee', $donor)
			)
		);

		return (boolean) $query->execute()->count();
	}
}