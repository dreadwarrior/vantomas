<?php
namespace DreadLabs\SecretSanta\Domain\Donee;

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

use DreadLabs\SecretSanta\Domain\Donor\DonorInterface;

/**
 * RepositoryInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface RepositoryInterface {

	/**
	 * Tries to find a non-mutual donee for the given donor
	 *
	 * @param DonorInterface $donor The Donor
	 *
	 * @return DoneeInterface
	 */
	public function findOneNonMutualFor(DonorInterface $donor);

	/**
	 * Finds a donee at random
	 *
	 * Needs the donor to build the exclude statement of the query.
	 *
	 * @param DonorInterface $donor The Donor to exclude by query
	 *
	 * @return DoneeInterface
	 */
	public function findOneAtRandomFor(DonorInterface $donor);
}
