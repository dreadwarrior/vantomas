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
 */
class ImageLayer implements LayerInterface {

	/**
	 * @var string
	 */
	private $resource;

	/**
	 * @var mixed
	 */
	private $width;

	/**
	 * @var mixed
	 */
	private $height;

	/**
	 * @var int
	 */
	private $minimumWidth;

	/**
	 * @var Offset
	 */
	private $offset;

	/**
	 * @param string $resource A valid TYPO3 file resource string
	 * @return self
	 */
	public function __construct($resource) {
		$this->resource = $resource;
	}

	/**
	 * @param mixed $width
	 * @return void
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * @param mixed $height
	 * @return void
	 */
	public function setHeight($height) {
		$this->height = $height;
	}

	/**
	 * @param mixed $minimumWidth
	 * @return void
	 */
	public function setMinimumWidth($minimumWidth) {
		$this->minimumWidth = $minimumWidth;
	}

	/**
	 * @param Offset $offset
	 * @return void
	 */
	public function setOffset(Offset $offset) {
		$this->offset = $offset;
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray() {
		$layer = array(
			'file' => $this->resource,
			'file.' => $this->getBoundaries(),
			'offset' => isset($this->offset) ? $this->offset->getValue() : '0,0',
		);

		return array('IMAGE', $layer);
	}

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
