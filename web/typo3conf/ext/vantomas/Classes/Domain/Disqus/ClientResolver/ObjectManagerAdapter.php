<?php
namespace DreadLabs\Vantomas\Domain\Disqus\ClientResolver;

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

use DreadLabs\VantomasWebsite\Disqus\Client\ResolverInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * TYPO3.CMS object manager adapter for client resolving
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ObjectManagerAdapter implements ResolverInterface {

	/**
	 * @var string
	 */
	private static $namespaceFormat = 'DreadLabs\\VantomasWebsite\\Disqus\\Client\\%s';

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
	 * {@inheritdoc}
	 */
	public function resolve($clientName) {
		return $this->objectManager->get($this->getClientNamespace($clientName));
	}

	/**
	 * @param string $clientName
	 * @return string
	 */
	private function getClientNamespace($clientName) {
		$clientName = GeneralUtility::underscoredToUpperCamelCase($clientName);

		return sprintf(self::$namespaceFormat, $clientName);
	}
}