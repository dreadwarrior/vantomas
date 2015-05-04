<?php
namespace DreadLabs\Vantomas\Domain\Disqus\ResponseResolver;

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

use DreadLabs\VantomasWebsite\Disqus\Response\AbstractResponse;
use DreadLabs\VantomasWebsite\Disqus\Response\ResolverInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * TYPO3.CMS object manager adapter for response resolving
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ObjectManagerAdapter implements ResolverInterface {

	/**
	 * @var string
	 */
	private static $namespaceFormat = 'DreadLabs\\VantomasWebsite\\Disqus\\Response\\%s';

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
	 * @param string $format
	 * @return AbstractResponse
	 */
	public function resolve($format) {
		$className = sprintf(self::$namespaceFormat, ucfirst($format));
		return $this->objectManager->get($className);
	}
}