<?php
namespace DreadLabs\Vantomas\Cache;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (typo3@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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