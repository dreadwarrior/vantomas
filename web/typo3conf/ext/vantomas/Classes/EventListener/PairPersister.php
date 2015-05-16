<?php
namespace DreadLabs\Vantomas\EventListener;

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

use DreadLabs\Vantomas\Domain\SecretSanta\Donee\DoneeInterface;
use DreadLabs\Vantomas\Domain\SecretSanta\Donor\DonorInterface;
use DreadLabs\Vantomas\Domain\Model\SecretSanta\Pair;
use DreadLabs\Vantomas\Domain\Repository\SecretSanta\PairRepository;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * PairPersister
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PairPersister {

	/**
	 * DI ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * PairRepository
	 *
	 * @var PairRepository
	 */
	private $pairRepository;

	/**
	 * Constructor
	 *
	 * @param ObjectManagerInterface $objectManager DI ObjectManager
	 * @param PairRepository $pairRepository PairRepository
	 */
	public function __construct(
		ObjectManagerInterface $objectManager,
		PairRepository $pairRepository
	) {
		$this->objectManager = $objectManager;
		$this->pairRepository = $pairRepository;
	}

	/**
	 * Persists a given donor/donee Pair
	 *
	 * @param DonorInterface $donor Donor
	 * @param DoneeInterface $donee Donee
	 *
	 * @return void
	 */
	public function persist(DonorInterface $donor, DoneeInterface $donee) {
		if (!$this->pairRepository->isPairExisting($donor, $donee)) {
			/* @var $pair Pair */
			$pair = $this->objectManager->get(Pair::class);
			$pair->setDonor($donor);
			$pair->setDonee($donee);

			$this->pairRepository->add($pair);
		}
	}
}
