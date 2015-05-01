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

use DreadLabs\VantomasWebsite\Media\Identifier;
use DreadLabs\VantomasWebsite\Media\StorageInterface;
use DreadLabs\VantomasWebsite\TeaserImage\Offset;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * A Canvas impl based on GIFBUILDER
 */
class Canvas extends AbstractGifbuilderCanvas {

	/**
	 * @var string
	 */
	private static $width = '546';

	/**
	 * @var string
	 */
	private static $height = '171';

	/**
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @var StorageInterface
	 */
	private $storage;

	/**
	 * @var string
	 */
	private $baseImageResource;

	/**
	 * @param ObjectManagerInterface $objectManager
	 * @param StorageInterface $storage
	 * @param ConfigurationManagerInterface $configurationManager
	 */
	public function __construct(
		ObjectManagerInterface $objectManager,
		StorageInterface $storage,
		ConfigurationManagerInterface $configurationManager
	) {
		$this->objectManager = $objectManager;
		$this->storage = $storage;

		parent::__construct($configurationManager);
	}

	/**
	 * @param string $resource
	 * @return void
	 */
	public function setBaseImageResource($resource) {
		$this->baseImageResource = $resource;
	}

	/**
	 * @return string
	 */
	public function render() {
		$this->addBaseImage();
		$this->addFoldedPaper();
		$this->addGrunge();

		return parent::render();
	}

	/**
	 * @return void
	 */
	private function addBaseImage() {
		$baseImage = $this->objectManager->get(
			ImageLayer::class,
			$this->getBaseImageResource()
		);
		$baseImage->setWidth(self::$width . 'm');
		$baseImage->setHeight(self::$height . 'c');
		$baseImage->setMinimumWidth(self::$width);

		$this->addLayer($baseImage);
	}

	/**
	 * Returns the base image resource
	 *
	 * @return string
	 */
	private function getBaseImageResource() {
		$resource = '';

		if ('' === $this->baseImageResource) {
			return $resource;
		}

		return $this->storage->getPublicPath(
			$this->getFirstMediaIdentifier()
		);
	}

	/**
	 * @return Identifier
	 */
	private function getFirstMediaIdentifier() {
		$fileIdentifiers = explode(',', $this->baseImageResource);
		$fileIdentifier = $this->objectManager->get(Identifier::class, $fileIdentifiers[0]);

		return $fileIdentifier;
	}

	/**
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