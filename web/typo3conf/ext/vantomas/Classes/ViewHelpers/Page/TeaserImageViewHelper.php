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

use DreadLabs\VantomasWebsite\TeaserImage\CanvasInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A page teaser image generator view helper which makes use of TypoScript cObj
 * IMG_RESOURCE & GIFBUILDER configuration.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TeaserImageViewHelper extends AbstractViewHelper {

	/**
	 * Canvas impl
	 *
	 * @var CanvasInterface
	 */
	private $canvas;

	/**
	 * Initializes the VH arguments
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('imageResource', 'string', 'The image resource. A CSV list of media resources.', TRUE);
	}

	/**
	 * Renders the VH
	 *
	 * @return string ready-to-use <img /> src-Attribute
	 */
	public function render() {
		$this->canvas = $this->objectManager->get(CanvasInterface::class);
		$this->canvas->setBaseImageResource($this->arguments['imageResource']);

		return $this->canvas->render();
	}
}
