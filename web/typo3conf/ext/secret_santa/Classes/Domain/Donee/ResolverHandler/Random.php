<?php
namespace DreadLabs\SecretSanta\Domain\Donee\ResolverHandler;

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

/**
 * Random
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Random implements ResolverHandlerInterface {

	/**
	 * Donee Repository
	 *
	 * @var RepositoryInterface
	 */
	private $doneeRepository;

	/**
	 * Constructor
	 *
	 * @param RepositoryInterface $doneeRepository Donee Repository
	 */
	public function __construct(
		RepositoryInterface $doneeRepository
	) {
		$this->doneeRepository = $doneeRepository;
	}

	/**
	 * Resolves a Donee for the incoming donor
	 *
	 * @param DonorInterface $donor The donor to fetch a donee for
	 *
	 * @return DoneeInterface
	 */
	public function resolve(DonorInterface $donor) {
		return $this->doneeRepository->findOneAtRandomFor($donor);
	}
}