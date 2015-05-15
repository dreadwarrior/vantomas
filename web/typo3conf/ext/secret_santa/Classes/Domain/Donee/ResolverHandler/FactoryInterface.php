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

use DreadLabs\SecretSanta\Domain\Donee\ResolverHandlerInterface;

/**
 * FactoryInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface FactoryInterface {

	/**
	 * Creates a ResolverHandler by given $name
	 *
	 * @param string $handlerName Name of the resolver handler to create
	 * @param ResolverHandlerInterface $nextHandler Next handler for the resolver
	 *
	 * @return ResolverHandlerInterface
	 */
	public function create($handlerName, ResolverHandlerInterface $nextHandler = NULL);
}
