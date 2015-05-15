<?php
namespace DreadLabs\SecretSanta\Domain\Donor;

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

use DreadLabs\SecretSanta\Domain\User\UserIdInterface;

/**
 * RepositoryInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface RepositoryInterface {

	/**
	 * Finds one donor by its UserId
	 *
	 * @param UserIdInterface $donorId The UserId of the donor
	 *
	 * @return DonorInterface
	 */
	public function findOneById(UserIdInterface $donorId);
}
