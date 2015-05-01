<?php
namespace DreadLabs\Vantomas\Domain\Twitter\Cache;

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

use DreadLabs\VantomasWebsite\Twitter\CacheInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

/**
 * Wraps the TYPO3.CMS cache_hash cache for twitter API responses
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Typo3CacheHash implements CacheInterface {

	/**
	 * @var FrontendInterface
	 */
	private $cache;

	/**
	 * @param CacheManager $cacheManager
	 * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
	 */
	public function __construct(CacheManager $cacheManager) {
		$this->cache = $cacheManager->getCache('cache_hash');
	}

	/**
	 * @param string $entryIdentifier
	 * @return boolean
	 */
	public function has($entryIdentifier) {
		return $this->cache->has($entryIdentifier);
	}

	/**
	 * @param string $entryIdentifier
	 * @param mixed $data
	 * @param array $tags
	 * @param int $lifetime
	 * @return void
	 */
	public function set($entryIdentifier, $data, array $tags = array(), $lifetime = NULL) {
		$this->cache->set($entryIdentifier, $data, $tags, $lifetime);
	}

	/**
	 * @param string $entryIdentifier
	 * @return mixed
	 */
	public function get($entryIdentifier) {
		return $this->cache->get($entryIdentifier);
	}
}
