<?php
namespace DreadLabs\VantomasWebsite\Twitter;

interface CacheInterface {

	/**
	 * @param string $entryIdentifier
	 * @return boolean
	 */
	public function has($entryIdentifier);

	/**
	 * @param string $entryIdentifier
	 * @param mixed $data
	 * @param array $tags
	 * @param int $lifetime
	 * @return void
	 */
	public function set($entryIdentifier, $data, array $tags = array(), $lifetime = NULL);

	/**
	 * @param string $entryIdentifier
	 * @return mixed
	 */
	public function get($entryIdentifier);
}