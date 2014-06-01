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
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * The Pair repository
 *
 * @package \DreadLabs\SecretSanta\Domain\Repository
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class PairRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

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
	 * @return NULL|\DreadLabs\SecretSanta\Domain\Model\Pair
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