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
}