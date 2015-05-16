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

use DreadLabs\VantomasWebsite\SecretSanta\Donee\ResolverHandler\FactoryInterface;
use DreadLabs\VantomasWebsite\SecretSanta\Donee\ResolverHandlerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Factory
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Factory implements FactoryInterface {

	/**
	 * DI ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	private $objectManager;


	/**
	 * Constructor
	 *
	 * @param ObjectManagerInterface $objectManager DI ObjectManager
	 */
	public function __construct(ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Creates a ResolverHandler by given $name
	 *
	 * @param string $handlerName Name of the resolver handler to create
	 * @param ResolverHandlerInterface $nextHandler Next handler for the resolver
	 *
	 * @return ResolverHandlerInterface
	 */
	public function create($handlerName, ResolverHandlerInterface $nextHandler = NULL) {
		if (is_null($nextHandler)) {
			return $this->objectManager->get($handlerName);
		}

		return $this->objectManager->get($handlerName, $nextHandler);
	}
}
