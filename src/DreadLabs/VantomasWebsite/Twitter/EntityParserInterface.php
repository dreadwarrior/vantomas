<?php
namespace DreadLabs\VantomasWebsite\Twitter;

interface EntityParserInterface {

	/**
	 * @param array $entities
	 * @return void
	 */
	public function setEntities(array $entities);

	/**
	 * @param string $tweet
	 * @return string
	 */
	public function parseUrls($tweet);

	/**
	 * @param string $tweet
	 * @return string
	 */
	public function parseHashTags($tweet);
}