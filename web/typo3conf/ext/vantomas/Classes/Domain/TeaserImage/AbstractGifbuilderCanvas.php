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
use DreadLabs\VantomasWebsite\TeaserImage\CanvasInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * A TypoScript GIFBUILDER canvas
 */
abstract class AbstractGifbuilderCanvas implements CanvasInterface {

	/**
	 * @var int
	 */
	private static $layerIndexIncrement = 10;

	/**
	 * @var ContentObjectRenderer
	 */
	protected $contentObject;

	/**
	 * @var array
	 */
	private $configuration;

	/**
	 * @var LayerInterface[]
	 */
	private $layers = array();

	/**
	 * @param ConfigurationManagerInterface $configurationManager
	 * @return self
	 */
	public function __construct(
		ConfigurationManagerInterface $configurationManager
	) {
		$this->contentObject = $configurationManager->getContentObject();

		$this->initialize();
	}

	/**
	 * @return void
	 */
	public function initialize() {
		$this->configuration = array(
			'file' => 'GIFBUILDER',
			'file.' => array(
				'XY' => '[10.w],[10.h]',
			),
		);
	}

	/**
	 * @param LayerInterface $layer
	 * @return void
	 */
	public function addLayer(LayerInterface $layer) {
		array_push($this->layers, $layer);
	}

	/**
	 * @param string $alternativeText
	 * @return void
	 */
	public function setAlternativeText($alternativeText) {
		$this->configuration['altText'] = (string) $alternativeText;
	}

	/**
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->configuration['title'] = (string) $title;
	}

	/**
	 * @return string
	 */
	public function render() {
		foreach ($this->layers as $index => $layer) {
			$layerIndex = ($index + 1) * self::$layerIndexIncrement;
			list($layerType, $layerConfiguration) = $layer->toArray();

			$this->configuration['file.'][$layerIndex] = $layerType;
			$this->configuration['file.'][$layerIndex . '.'] = $layerConfiguration;
		}

		return $this->contentObject->cObjGetSingle('IMAGE', $this->configuration);
	}
}
