<?php
namespace DreadLabs\Vantomas\Domain\Migration\Locking;

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

use NinjaMutex\Lock\FlockLock;

/**
 * Typo3TempFlockLock
 *
 * Extends the NinjaMutex Flocklock with a directly set
 * lock file path to the TYPO3.CMS temp directory.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Typo3TempFlockLock extends FlockLock {

	/**
	 * Constructor
	 */
	public function __construct() {
		$directory = PATH_site . '/typo3temp/';

		parent::__construct($directory);
	}
}
