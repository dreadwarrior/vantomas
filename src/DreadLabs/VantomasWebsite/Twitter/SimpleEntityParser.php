<?php
namespace DreadLabs\VantomasWebsite\Twitter;

class SimpleEntityParser implements EntityParserInterface {

	/**
	 * @var array
	 */
	private $entities;

	/**
	 * @param \stdClass $entities
	 * @return void
	 */
	public function setEntities(\stdClass $entities) {
		$this->entities = $entities;
	}

	/**
	 * @param string $tweet
	 * @return string
	 */
	public function parseUrls($tweet) {
		foreach ($this->entities->urls as $url) {
			$tweet = str_replace($url->url, '<a href="' . $url->url . '">' . $url->url . '</a>', $tweet);
		}

		return $tweet;
	}

	/**
	 * @param string $tweet
	 * @return string
	 */
	public function parseHashTags($tweet) {
		foreach ($this->entities->hashtags as $hashTag) {
			$tweet = str_replace(
				'#' . $hashTag->text,
				'<a href="https://twitter.com/search?q=%23' . $hashTag->text . '&src=hash">#' . $hashTag->text . '</a>',
				$tweet
			);
		}

		return $tweet;
	}
}