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

use DreadLabs\VantomasWebsite\Page\PageId;
use DreadLabs\VantomasWebsite\TeaserImage\Offset;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * A Canvas impl based on GIFBUILDER
 *
 * @author Thomas Juhnke <typo@van-tomas.de>
 */
class Canvas extends AbstractGifbuilderCanvas {

	/**
	 * Canvas width
	 *
	 * @var string
	 */
	private static $width = '546';

	/**
	 * Canvas height
	 *
	 * @var string
	 */
	private static $height = '171';

	/**
	 * DIC ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * Base image resource name
	 *
	 * @var string
	 */
	private $baseImageResource;

	/**
	 * Constructor
	 *
	 * @param ObjectManagerInterface $objectManager DIC ObjectManager
	 * @param ConfigurationManagerInterface $configurationManager Application
	 * ConfigurationManager
	 */
	public function __construct(
		ObjectManagerInterface $objectManager,
		ConfigurationManagerInterface $configurationManager
	) {
		$this->objectManager = $objectManager;

		parent::__construct($configurationManager);
	}

	/**
	 * Sets the base image resource
	 *
	 * @param string $resource Path and file name of the base image resource
	 *
	 * @return void
	 */
	public function setBaseImageResource($resource) {
		$this->baseImageResource = $resource;
	}

	/**
	 * Renders the canvas
	 *
	 * @return string
	 */
	public function render() {
		$this->addBaseImage();
		$this->addFoldedPaper();
		$this->addGrunge();

		return parent::render();
	}

	/**
	 * Adds the base image
	 *
	 * @return void
	 */
	private function addBaseImage() {
		$baseImage = $this->objectManager->get(
			ImageLayer::class,
			$this->baseImageResource
		);
		$baseImage->setWidth(self::$width . 'm');
		$baseImage->setHeight(self::$height . 'c');
		$baseImage->setMinimumWidth(self::$width);

		$this->addLayer($baseImage);
	}

	/**
	 * Adds the folded paper layer
	 *
	 * @return void
	 */
	private function addFoldedPaper() {
		$foldedPaper = $this->objectManager->get(
			ImageLayer::class,
			'EXT:vantomas/Resources/Public/Images/folded-paper.png'
		);
		$foldedPaper->setWidth(self::$width . 'm');
		$foldedPaper->setMinimumWidth(self::$width);

		$this->addLayer($foldedPaper);
	}

	/**
	 * Adds the grunge layer
	 *
	 * @return void
	 */
	private function addGrunge() {

		$grunge = $this->objectManager->get(
			ImageLayer::class,
			'EXT:vantomas/Resources/Public/Images/grunge.png'
		);
		$grunge->setOffset(Offset::fromString('0,-5'));

		$this->addLayer($grunge);
	}
}
