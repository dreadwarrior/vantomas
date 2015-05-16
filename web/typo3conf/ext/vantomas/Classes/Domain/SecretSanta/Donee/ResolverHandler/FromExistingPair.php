<?php
namespace DreadLabs\Vantomas\Domain\SecretSanta\Donee\ResolverHandler;

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
use DreadLabs\Vantomas\Domain\SecretSanta\Donee\ResolverHandlerInterface;
use DreadLabs\Vantomas\Domain\SecretSanta\Donor\DonorInterface;
use DreadLabs\Vantomas\Domain\Repository\SecretSanta\PairRepository;

/**
 * FromExistingPair
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FromExistingPair implements ResolverHandlerInterface {

	/**
	 * Next resolver within the chain
	 *
	 * @var ResolverHandlerInterface
	 */
	private $nextResolver;

	/**
	 * PairRepository
	 *
	 * @var PairRepository
	 */
	private $pairRepository;

	/**
	 * Constructor
	 *
	 * @param ResolverHandlerInterface $nextResolver Next resolver within the chain
	 * @param PairRepository $pairRepository PairRepository
	 */
	public function __construct(
		ResolverHandlerInterface $nextResolver,
		PairRepository $pairRepository
	) {
		$this->nextResolver = $nextResolver;
		$this->pairRepository = $pairRepository;
	}

	/**
	 * Resolves a Donee for the incoming donor
	 *
	 * @param DonorInterface $donor The donor to fetch a donee for
	 *
	 * @return DoneeInterface
	 */
	public function resolve(DonorInterface $donor) {
		$pair = $this->pairRepository->findPairFor($donor);

		return !is_null($pair) ? $pair->getDonee() : $this->nextResolver->resolve($donor);
	}
}