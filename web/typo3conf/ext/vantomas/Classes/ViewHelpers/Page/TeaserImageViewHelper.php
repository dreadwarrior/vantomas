<?php
namespace DreadLabs\Vantomas\ViewHelpers\Page;

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
use DreadLabs\VantomasWebsite\TeaserImage\CanvasFactoryInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * A page teaser image generator view helper which makes use of TypoScript cObj
 * IMG_RESOURCE & GIFBUILDER configuration.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TeaserImageViewHelper extends AbstractViewHelper {

	/**
	 * Canvas factory impl
	 *
	 * @var CanvasFactoryInterface
	 */
	private $canvasFactory;

	/**
	 * Injects the Canvas factory impl
	 *
	 * @param CanvasFactoryInterface $canvasFactory Canvas factory impl
	 *
	 * @return void
	 */
	public function injectCanvasFactory(CanvasFactoryInterface $canvasFactory) {
		$this->canvasFactory = $canvasFactory;
	}

	/**
	 * Initializes the VH arguments
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument(
			'pageId',
			PageId::class,
			'PageId from which to render the image out of the `media` field.',
			TRUE
		);
	}

	/**
	 * Renders the VH
	 *
	 * @return string ready-to-use <img /> src-Attribute
	 */
	public function render() {
		return $this->canvasFactory->create($this->getBaseImageResource())->render();
	}

	/**
	 * Resolves the base image resource string
	 *
	 * This method ensures that the page overlays, translations etc.
	 * will be loaded by the TYPO3.CMS core for the specified field.
	 *
	 * @return string
	 */
	private function getBaseImageResource() {
		$configuration = array(
			'references.' => array(
				'table' => 'pages',
				'uid' => $this->getPageIdFromArguments()->getValue(),
				'fieldName' => 'media',
			),
			'begin' => 0,
			'maxItems' => 1,
			'renderObj' => 'TEXT',
			'renderObj.' => array(
				'stdWrap.' => array(
					'data' => 'file:current:publicUrl',
				),
			),
		);

		return $this->getContentObjectRenderer()->cObjGetSingle('FILES', $configuration);
	}

	/**
	 * Returns the PageId given to the VH arguments
	 *
	 * @return PageId
	 */
	private function getPageIdFromArguments() {
		return $this->arguments['pageId'];
	}

	/**
	 * Returns a ContentObjectRenderer instance
	 *
	 * @return ContentObjectRenderer
	 */
	private function getContentObjectRenderer() {
		return $this->objectManager->get(ContentObjectRenderer::class);
	}
}
