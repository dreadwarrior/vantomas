<?php
namespace DreadLabs\VantomasWebsite\Twitter;

interface EntityParserInterface {

	/**
	 * @param \stdClass $entities
	 * @return void
	 */
	public function setEntities(\stdClass $entities);

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