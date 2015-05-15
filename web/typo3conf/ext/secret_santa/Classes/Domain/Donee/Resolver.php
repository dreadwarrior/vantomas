<?php
namespace DreadLabs\SecretSanta\Domain\Donee;

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

use DreadLabs\SecretSanta\Domain\Donee\Resolver\FactoryInterface;
use DreadLabs\SecretSanta\Domain\Donee\Resolver\FromExistingPair;
use DreadLabs\SecretSanta\Domain\Donee\Resolver\NonMutual;
use DreadLabs\SecretSanta\Domain\Donee\Resolver\Random;
use DreadLabs\SecretSanta\Domain\Donor\RepositoryInterface;
use DreadLabs\SecretSanta\Domain\User\UserIdInterface;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * Resolver
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Resolver implements ResolverInterface {

	/**
	 * DonorRepository
	 *
	 * @var RepositoryInterface
	 */
	private $donorRepository;

	/**
	 * A resolver factory
	 *
	 * @var FactoryInterface
	 */
	private $resolverFactory;

	/**
	 * Signal/Slot Dispatcher
	 *
	 * @var Dispatcher
	 */
	private $signalSlotDispatcher;

	/**
	 * Constructor
	 *
	 * @param RepositoryInterface $donorRepository Donor Repository
	 * @param FactoryInterface $resolverFactory A resolver factory
	 * @param Dispatcher $signalSlotDispatcher Signal/Slot Dispatcher
	 */
	public function __construct(
		RepositoryInterface $donorRepository,
		FactoryInterface $resolverFactory,
		Dispatcher $signalSlotDispatcher
	) {
		$this->donorRepository = $donorRepository;
		$this->resolverFactory = $resolverFactory;
		$this->signalSlotDispatcher = $signalSlotDispatcher;
	}

	/**
	 * Resolves a donee for the incoming donor user id
	 *
	 * @param UserIdInterface $donorId User id of the donor
	 *
	 * @return DoneeInterface A donee
	 */
	public function resolveFor(UserIdInterface $donorId) {
		$donor = $this->donorRepository->findOneById($donorId);

		$randomResolver = $this->resolverFactory->create(Random::class);
		$nonMutualResolver = $this->resolverFactory->create(NonMutual::class, $randomResolver);
		$existingPairResolver = $this->resolverFactory->create(FromExistingPair::class, $nonMutualResolver);

		$donee = $existingPairResolver->resolve($donor);

		$this->signalSlotDispatcher->dispatch(__CLASS__, 'foundDonee', array($donor, $donee));

		return $donee;
	}
}
