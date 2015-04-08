<?php
namespace DreadLabs\VantomasWebsite\TeaserImage;

/**
 * Offset configuration for Layers
 */
class Offset {

	/**
	 * @var int
	 */
	private $xAxis;

	/**
	 * @var int
	 */
	private $yAxis;

	/**
	 * @param int $xAxis
	 * @param int $yAxis
	 * @return self
	 */
	public function __construct($xAxis, $yAxis) {
		$this->xAxis = (int) $xAxis;
		$this->yAxis = (int) $yAxis;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return implode(',', array($this->xAxis, $this->yAxis));
	}

	/**
	 * @param string $axes
	 * @return self
	 */
	public static function fromString($axes) {
		list($xAxis, $yAxis) = explode(',', $axes);

		return new static($xAxis, $yAxis);
	}
}