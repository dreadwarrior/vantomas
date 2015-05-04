<?php
namespace DreadLabs\Vantomas\Domain\TeaserImage;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use DreadLabs\VantomasWebsite\TeaserImage\LayerInterface;
use DreadLabs\VantomasWebsite\TeaserImage\Offset;

/**
 * A TypoScript cObj `IMAGE` wrapper
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ImageLayer implements LayerInterface {

	/**
	 * A valid TYPO3 file resource string
	 *
	 * @var string
	 */
	private $resource;

	/**
	 * Image width
	 *
	 * @var mixed
	 */
	private $width;

	/**
	 * Image height
	 *
	 * @var mixed
	 */
	private $height;

	/**
	 * Image minimum width
	 *
	 * @var int
	 */
	private $minimumWidth;

	/**
	 * Layer offset
	 *
	 * @var Offset
	 */
	private $offset;

	/**
	 * Constructor
	 *
	 * @param string $resource A valid TYPO3 file resource string
	 */
	public function __construct($resource) {
		$this->resource = $resource;
	}

	/**
	 * Sets the layer width
	 *
	 * @param mixed $width Width
	 *
	 * @return void
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * Sets the layer height
	 *
	 * @param mixed $height Height
	 *
	 * @return void
	 */
	public function setHeight($height) {
		$this->height = $height;
	}

	/**
	 * Sets the minimum layer width
	 *
	 * @param mixed $minimumWidth Minimum width
	 *
	 * @return void
	 */
	public function setMinimumWidth($minimumWidth) {
		$this->minimumWidth = $minimumWidth;
	}

	/**
	 * Sets the layer offset
	 *
	 * @param Offset $offset Offset
	 *
	 * @return void
	 */
	public function setOffset(Offset $offset) {
		$this->offset = $offset;
	}

	/**
	 * Provides an array representation of the layer
	 *
	 * @return array
	 */
	public function toArray() {
		$layer = array(
			'file' => $this->resource,
			'file.' => $this->getBoundaries(),
			'offset' => isset($this->offset) ? $this->offset->getValue() : '0,0',
		);

		return array('IMAGE', $layer);
	}

	/**
	 * Returns the layer boundaries
	 *
	 * It recognizes the settings for width, height and minimum width
	 * to set the boundaries for this layer.
	 *
	 * @return array
	 */
	private function getBoundaries() {
		$boundaries = array();
		if (isset($this->width)) {
			$boundaries['width'] = $this->width;
		}
		if (isset($this->height)) {
			$boundaries['height'] = $this->height;
		}
		if (isset($this->minimumWidth)) {
			$boundaries['minW'] = $this->minimumWidth;
		}

		return $boundaries;
	}
}
