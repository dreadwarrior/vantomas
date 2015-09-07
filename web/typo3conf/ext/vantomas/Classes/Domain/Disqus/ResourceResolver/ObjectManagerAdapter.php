<?php
namespace DreadLabs\Vantomas\Domain\Disqus\ResourceResolver;

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

use DreadLabs\VantomasWebsite\Disqus\Resource\AbstractResource;
use DreadLabs\VantomasWebsite\Disqus\Resource\ResolverInterface;
use DreadLabs\VantomasWebsite\Disqus\Resource\ResolverPatternProviderInterface;
use TYPO3\CMS\Extbase\Object\Container\Exception\UnknownObjectException;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * TYPO3.CMS object manager adapter for resource resolving
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ObjectManagerAdapter implements ResolverInterface {

	/**
	 * The DIC ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * The provider for resolving the resource
	 *
	 * @var ResolverPatternProviderInterface
	 */
	private $patternProvider;

	/**
	 * Constructor
	 *
	 * @param ObjectManagerInterface $objectManager The DIC ObjectManager
	 * @param ResolverPatternProviderInterface $patternProvider Pattern provider
	 */
	public function __construct(ObjectManagerInterface $objectManager, ResolverPatternProviderInterface $patternProvider) {
		$this->objectManager = $objectManager;
		$this->patternProvider = $patternProvider;
	}

	/**
	 * Resolves a concrete resource by topic + action
	 *
	 * @param string $topic The resource topic, e.g "forums"
	 * @param string $action The resource action, e.g. "listPosts"
	 *
	 * @return AbstractResource
	 * @throws UnknownObjectException Is re-thrown if the DIC ObjectManager
	 * can not resolve a proper resource object instance.
	 */
	public function resolve($topic, $action) {
		try {
			return $this->objectManager->get(sprintf($this->patternProvider->getPattern(), $topic, $action));
		} catch (\Exception $e) {
			throw new UnknownObjectException('The resource ' . $topic . '/' . $action . ' is currently not implemented!', 1367666179);
		}
	}
}
