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
 * AbstractUserId
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
abstract class AbstractUserId implements UserIdInterface {

	/**
	 * The User id value
	 *
	 * @var int
	 */
	private $value;

	/**
	 * Constructor
	 *
	 * @param int $userId The user id
	 */
	public function __construct($userId) {
		$this->value = (int) $userId;
	}

	/**
	 * Named constructor
	 *
	 * @param int $userId The user id
	 *
	 * @return static
	 */
	public static function fromString($userId) {
		return new static($userId);
	}

	/**
	 * Returns the user id value
	 *
	 * @return int
	 */
	public function getValue() {
		return $this->value;
	}
}
