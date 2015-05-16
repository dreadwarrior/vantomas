<?php
namespace DreadLabs\Vantomas\Domain\User;

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

/**
 * UserIdInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface UserIdInterface {

	/**
	 * Named constructor
	 *
	 * @param int $userId The User id
	 *
	 * @return UserIdInterface
	 */
	public static function fromString($userId);

	/**
	 * Named constructor
	 *
	 * @return UserIdInterface
	 */
	public static function fromLoggedInUser();

	/**
	 * Returns the user id value
	 *
	 * @return int
	 */
	public function getValue();
}
