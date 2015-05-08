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

use DreadLabs\VantomasWebsite\TeaserImage\CanvasFactoryInterface;
use DreadLabs\VantomasWebsite\TeaserImage\CanvasInterface;
use DreadLabs\VantomasWebsite\TeaserImage\LayerInterface;
use DreadLabs\VantomasWebsite\TeaserImage\Offset;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * FoldedPaperWithGrungeCanvasFactory
 *
 * This teaser image canvas factory adds the base image and applies a folded
 * paper and grunge image layer to provide the unique teaser image look.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FoldedPaperWithGrungeCanvasFactory implements CanvasFactoryInterface {

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
	 * DI ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * The Canvas to draw upon
	 *
	 * @var CanvasInterface
	 */
	private $canvas;

	/**
	 * Constructor
	 *
	 * @param ObjectManagerInterface $objectManager DI ObjectManager
	 */
	public function __construct(ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * CCreates a teaser image canvas instance
	 *
	 * Furthermore, it adds the folded paper + grunge layers
	 *
	 * @param string $baseImage A valid base image resource string
	 *
	 * @return CanvasInterface
	 */
	public function create($baseImage) {
		$this->canvas = $this->objectManager->get(CanvasInterface::class);

		$this->canvas->addLayer($this->getBaseImageLayer($baseImage));
		$this->canvas->addLayer($this->getFoldedPaperLayer());
		$this->canvas->addLayer($this->getGrungeLayer());

		return $this->canvas;
	}

	/**
	 * Get the base image layer
	 *
	 * @param string $baseImageResource A valid TYPO3.CMS file resource string
	 *
	 * @return LayerInterface
	 */
	private function getBaseImageLayer($baseImageResource) {
		$baseImage = $this->objectManager->get(
			ImageLayer::class,
			$baseImageResource
		);
		$baseImage->setWidth(self::$width . 'm');
		$baseImage->setHeight(self::$height . 'c');
		$baseImage->setMinimumWidth(self::$width);

		return $baseImage;
	}

	/**
	 * Get the folded paper layer
	 *
	 * @return LayerInterface
	 */
	private function getFoldedPaperLayer() {
		$foldedPaper = $this->objectManager->get(
			ImageLayer::class,
			'EXT:vantomas/Resources/Public/Images/folded-paper.png'
		);
		$foldedPaper->setWidth(self::$width . 'm');
		$foldedPaper->setMinimumWidth(self::$width);

		return $foldedPaper;
	}

	/**
	 * Get the grunge layer
	 *
	 * @return LayerInterface
	 */
	private function getGrungeLayer() {
		$grunge = $this->objectManager->get(
			ImageLayer::class,
			'EXT:vantomas/Resources/Public/Images/grunge.png'
		);
		$grunge->setOffset(Offset::fromString('0,-5'));

		return $grunge;
	}
}