<?php
namespace DreadLabs\Vantomas\Disqus\ResourceResolver;

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Thomas Juhnke (typo3@van-tomas.de)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\VantomasWebsite\Disqus\Resource\AbstractResource;
use DreadLabs\VantomasWebsite\Disqus\Resource\ResolverInterface;
use TYPO3\CMS\Extbase\Object\Container\Exception\UnknownObjectException;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

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