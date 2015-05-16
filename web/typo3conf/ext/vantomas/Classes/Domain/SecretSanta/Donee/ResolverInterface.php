<?php
namespace DreadLabs\Vantomas\Domain\SecretSanta\Donee;

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

use DreadLabs\Vantomas\Domain\User\UserIdInterface;

/**
 * ResolverInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface ResolverInterface {

	/**
	 * Resolves a donee for the incoming donor user id
	 *
	 * @param UserIdInterface $donorId User id of the donor
	 *
	 * @return DoneeInterface A donee
	 */
	public function resolveFor(UserIdInterface $donorId);
}
