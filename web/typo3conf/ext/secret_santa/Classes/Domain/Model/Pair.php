<?php
namespace DreadLabs\SecretSanta\Domain\Model;

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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Pair
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Pair extends AbstractEntity {

	/**
	 * FrontendUser
	 *
	 * @var \DreadLabs\SecretSanta\Domain\Model\FrontendUser
	 */
	protected $donor;

	/**
	 * FrontendUser
	 *
	 * @var \DreadLabs\SecretSanta\Domain\Model\FrontendUser
	 */
	protected $donee;

	/**
	 * Returns the donor
	 *
	 * @return FrontendUser
	 */
	public function getDonor() {
		return $this->donor;
	}

	/**
	 * Sets the donor
	 *
	 * @param FrontendUser $donor FrontendUser
	 *
	 * @return void
	 */
	public function setDonor(FrontendUser $donor) {
		$this->donor = $donor;
	}

	/**
	 * Returns the donee
	 *
	 * @return FrontendUser
	 */
	public function getDonee() {
		return $this->donee;
	}

	/**
	 * Sets the donee
	 *
	 * @param FrontendUser $donee FrontendUser
	 *
	 * @return void
	 */
	public function setDonee(FrontendUser $donee) {
		$this->donee = $donee;
	}
}
