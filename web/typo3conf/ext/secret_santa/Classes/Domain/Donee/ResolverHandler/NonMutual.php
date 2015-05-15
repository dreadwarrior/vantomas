<?php
namespace DreadLabs\SecretSanta\Domain\Donee\Resolver;

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
use DreadLabs\SecretSanta\Domain\Donee\RepositoryInterface;
use DreadLabs\SecretSanta\Domain\Donee\ResolverHandlerInterface;
use DreadLabs\SecretSanta\Domain\Donor\DonorInterface;
use DreadLabs\SecretSanta\Domain\Repository\PairRepository;

/**
 * NonMutual
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class NonMutual implements ResolverHandlerInterface {

	/**
	 * Amount of maximum loops to find a non-mutual donee
	 *
	 * @var int
	 */
	const MAX_MUTUAL_LOOP = 1000;

	/**
	 * Next resolver within the chain
	 *
	 * @var ResolverHandlerInterface
	 */
	private $nextResolver;

	/**
	 * Donee Repository
	 *
	 * @var RepositoryInterface
	 */
	private $doneeRepository;

	/**
	 * Pair Repository
	 *
	 * @var PairRepository
	 */
	private $pairRepository;

	/**
	 * Constructor
	 *
	 * @param ResolverHandlerInterface $nextResolver Next resolver within the chain
	 * @param RepositoryInterface $doneeRepository Donee Repository
	 * @param PairRepository $pairRepository PairRepository
	 */
	public function __construct(
		ResolverHandlerInterface $nextResolver,
		RepositoryInterface $doneeRepository,
		PairRepository $pairRepository
	) {
		$this->nextResolver = $nextResolver;
		$this->doneeRepository = $doneeRepository;
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
		$mutualIncrement = 0;

		do {
			$donee = $this->doneeRepository->findOneNonMutualFor($donor);

			$mutualIncrement++;

			if ($mutualIncrement >= self::MAX_MUTUAL_LOOP) {
				$donee = NULL;
				break;
			}
			if (!$this->pairRepository->isPairMutually($donor, $donee)) {
				break;
			}
		} while (0);

		return !is_null($donee) ? $donee : $this->nextResolver->resolve($donor);
	}
}
