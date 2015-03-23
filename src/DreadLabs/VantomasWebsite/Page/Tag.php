<?php
namespace DreadLabs\VantomasWebsite\Page;

class Tag {

	/**
	 * @var string
	 */
	private $tag;

	/**
	 * @param string $tag
	 */
	public function __construct($tag) {
		$this->tag = (string) $tag;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->tag;
	}

	/**
	 * @param string $tag
	 * @return self
	 */
	public static function fromString($tag) {
		return new static((string) $tag);
	}

	/**
	 * @param $tag
	 * @return self
	 */
	public static function fromUrl($tag) {
		return new static(urldecode((string) $tag));
	}
}