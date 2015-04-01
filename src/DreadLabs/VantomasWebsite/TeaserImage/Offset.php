<?php
namespace DreadLabs\VantomasWebsite\TeaserImage;

class Offset {

	/**
	 * @var int
	 */
	private $xAxis;

	/**
	 * @var int
	 */
	private $yAxis;

	public function __construct($xAxis, $yAxis) {
		$this->xAxis = (int) $xAxis;
		$this->yAxis = (int) $yAxis;
	}

	public function getValue() {
		return implode(',', array($this->xAxis, $this->yAxis));
	}

	public static function fromString($axes) {
		list($xAxis, $yAxis) = explode(',', $axes);

		return new static($xAxis, $yAxis);
	}
}