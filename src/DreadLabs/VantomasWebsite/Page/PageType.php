<?php
namespace DreadLabs\VantomasWebsite\Page;

class PageType {

	/**
	 * @var int
	 */
	private $value;

	public function __construct($pageType) {
		$this->value = (int) $pageType;
	}

	/**
	 * @return int
	 */
	public function getValue() {
		return $this->value;
	}
}