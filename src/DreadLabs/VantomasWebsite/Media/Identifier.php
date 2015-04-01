<?php
namespace DreadLabs\VantomasWebsite\Media;

class Identifier {

	/**
	 * @var string
	 */
	private $value;

	public function __construct($value) {
		$this->value = (string) $value;
	}

	public function getValue() {
		return $this->value;
	}
}