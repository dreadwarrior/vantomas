<?php
namespace DreadLabs\VantomasWebsite\Page;

class PageId {

	/**
	 * @var int
	 */
	private $value;

	public function __construct($pageId) {
		$this->value = (int) $pageId;
	}

	/**
	 * @return int
	 */
	public function getValue() {
		return $this->value;
	}
}