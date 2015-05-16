<?php
namespace DreadLabs\Vantomas\Domain\EventListener;

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

use DreadLabs\VantomasWebsite\EventListener\PersistSecretSantaPairListenerInterface;
use DreadLabs\VantomasWebsite\SecretSanta\Donee\DoneeInterface;
use DreadLabs\VantomasWebsite\SecretSanta\Donor\DonorInterface;
use DreadLabs\VantomasWebsite\SecretSanta\Pair\PairInterface;
use DreadLabs\VantomasWebsite\SecretSanta\Pair\RepositoryInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * PersistSecretSantaPairListener
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PersistSecretSantaPairListener implements PersistSecretSantaPairListenerInterface {

	/**
	 * DI ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * Pair Repository
	 *
	 * @var RepositoryInterface
	 */
	private $pairRepository;

	/**
	 * Constructor
	 *
	 * @param ObjectManagerInterface $objectManager DI ObjectManager
	 * @param RepositoryInterface $pairRepository PairRepository
	 */
	public function __construct(
		ObjectManagerInterface $objectManager,
		RepositoryInterface $pairRepository
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
	public function handle(DonorInterface $donor, DoneeInterface $donee) {
		if (!$this->pairRepository->isPairExisting($donor, $donee)) {
			/* @var $pair PairInterface */
			$pair = $this->objectManager->get(PairInterface::class);
			$pair->setDonor($donor);
			$pair->setDonee($donee);

			$this->pairRepository->attach($pair);
		}
	}
}
