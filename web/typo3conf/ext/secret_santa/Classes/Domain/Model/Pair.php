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

use DreadLabs\SecretSanta\Domain\Donee\DoneeInterface;
use DreadLabs\SecretSanta\Domain\Donor\DonorInterface;
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
	 * @var \DreadLabs\SecretSanta\Domain\Model\Donor
	 */
	protected $donor;

	/**
	 * Donee
	 *
	 * @var \DreadLabs\SecretSanta\Domain\Model\Donee
	 */
	protected $donee;

	/**
	 * Returns the donor
	 *
	 * @return DonorInterface
	 */
	public function getDonor() {
		return $this->donor;
	}

	/**
	 * Sets the donor
	 *
	 * @param DonorInterface $donor Donor
	 *
	 * @return void
	 */
	public function setDonor(DonorInterface $donor) {
		$this->donor = $donor;
	}

	/**
	 * Returns the donee
	 *
	 * @return DoneeInterface
	 */
	public function getDonee() {
		return $this->donee;
	}

	/**
	 * Sets the donee
	 *
	 * @param DoneeInterface $donee Donee
	 *
	 * @return void
	 */
	public function setDonee(DoneeInterface $donee) {
		$this->donee = $donee;
	}
}
