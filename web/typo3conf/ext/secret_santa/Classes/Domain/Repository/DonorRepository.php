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

use DreadLabs\SecretSanta\Domain\Donor\DonorInterface;
use DreadLabs\SecretSanta\Domain\Donor\RepositoryInterface;
use DreadLabs\SecretSanta\Domain\User\UserIdInterface;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;

/**
 * DonorRepository
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class DonorRepository extends FrontendUserRepository implements RepositoryInterface {

	/**
	 * Finds a donor
	 *
	 * @param UserIdInterface $donorId The UserId of the d onor
	 *
	 * @return DonorInterface
	 */
	public function findOneById(UserIdInterface $donorId) {
		return $this->findByUid($donorId->getValue());
	}
}
