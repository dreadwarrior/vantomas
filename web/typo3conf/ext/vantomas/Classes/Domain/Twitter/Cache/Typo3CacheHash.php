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
class Typo3CacheHash implements CacheInterface
{

    /**
     * Cache frontend
     *
     * @var FrontendInterface
     */
    private $cache;

    /**
     * Construct
     *
     * @param CacheManager $cacheManager Application CacheManager
     *
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException The application
     * caching framework will throw this exception if the specified cache isn't
     * properly configured.
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->cache = $cacheManager->getCache('cache_hash');
    }

    /**
     * Checks if the given identifier is cached already
     *
     * @param string $entryIdentifier Cache entry identifier
     *
     * @return bool
     */
    public function has($entryIdentifier)
    {
        return $this->cache->has($entryIdentifier);
    }

    /**
     * Sets the data for the given cache entry identifier
     *
     * @param string $entryIdentifier Cache entry identifier
     * @param mixed $data Data for the cache entry
     * @param array $tags Cache tags
     * @param int $lifetime Lifetime of the cache entry
     *
     * @return void
     */
    public function set($entryIdentifier, $data, array $tags = array(), $lifetime = null)
    {
        $this->cache->set($entryIdentifier, $data, $tags, $lifetime);
    }

    /**
     * Returns a cache entry
     *
     * @param string $entryIdentifier Cache entry identifier
     *
     * @return mixed
     */
    public function get($entryIdentifier)
    {
        return $this->cache->get($entryIdentifier);
    }
}
