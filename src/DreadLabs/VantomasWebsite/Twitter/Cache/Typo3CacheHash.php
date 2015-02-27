<?php
namespace DreadLabs\VantomasWebsite\Twitter\Cache;

use DreadLabs\VantomasWebsite\Twitter\CacheInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

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