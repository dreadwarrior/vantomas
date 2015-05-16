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

use DreadLabs\VantomasWebsite\SecretSanta\Donee\DoneeInterface;
use DreadLabs\VantomasWebsite\SecretSanta\Donor\DonorInterface;
use DreadLabs\VantomasWebsite\SecretSanta\Pair\PairInterface;
use DreadLabs\VantomasWebsite\SecretSanta\Pair\RepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The Pair repository
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PairRepository extends Repository implements RepositoryInterface {

	/**
	 * Try to find a pair for the given $donor
	 *
	 * @param DonorInterface $donor Donor
	 *
	 * @return NULL|PairInterface
	 */
	public function findPairFor(DonorInterface $donor) {
		$query = $this->createQuery();

		$query->matching(
			$query->equals('donor', $donor)
		);

		return $query->execute()->getFirst();
	}

	/**
	 * Checks if the pair is mutually
	 *
	 * @param DonorInterface $donor Donor
	 * @param DoneeInterface $donee Donee
	 *
	 * @return bool
	 */
	public function isPairMutually(
		DonorInterface $donor,
		DoneeInterface $donee
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

	/**
	 * Checks if a given donor/donee pair is existing
	 *
	 * @param DonorInterface $donor Donor
	 * @param DoneeInterface $donee Donee
	 *
	 * @return bool
	 */
	public function isPairExisting(DonorInterface $donor, DoneeInterface $donee) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->logicalAnd(
				$query->equals('donor', $donor),
				$query->equals('donee', $donee)
			)
		);

		return (boolean) $query->execute()->count();
	}

	/**
	 * Adds the incoming pair to the persistence layer
	 *
	 * @param PairInterface $pair Pair to persist
	 *
	 * @return void
	 *
	 * @throws IllegalObjectTypeException If incoming object is not of expected type
	 */
	public function attach(PairInterface $pair) {
		parent::add($pair);
	}
}
