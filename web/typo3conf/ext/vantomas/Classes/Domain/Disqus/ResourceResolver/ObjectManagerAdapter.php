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
use TYPO3\CMS\Extbase\Object\Container\Exception\UnknownObjectException;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * TYPO3.CMS object manager adapter for resource resolving
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ObjectManagerAdapter implements ResolverInterface {

	/**
	 * @var string
	 */
	private static $namespaceFormat = 'DreadLabs\\VantomasWebsite\\Disqus\\Resource\\%s\\%s';

	/**
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @param ObjectManagerInterface $objectManager
	 */
	public function __construct(ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Resolves a concrete resource by topic + action
	 *
	 * @param string $topic
	 * @param string $action
	 * @return AbstractResource
	 * @throws UnknownObjectException
	 */
	public function resolve($topic, $action) {
		try {
			return $this->objectManager->get(sprintf(self::$namespaceFormat, $topic, $action));
		} catch (\Exception $e) {
			throw new UnknownObjectException('The resource ' . $topic . '/' . $action . ' is currently not implemented!', 1367666179);
		}
	}
}