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
 * IMAGE & GIFBUILDER configuration.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TeaserImageViewHelper extends AbstractViewHelper {

	/**
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
		$this->registerArgument('titleText', 'string', 'Title text', FALSE, '');
		$this->registerArgument('titleTextAlternative', 'string', 'Title text fallback/alternative', FALSE, '');
	}

	/**
	 * Renders the VH
	 *
	 * @return string ready-to-use <img />-Tag
	 */
	public function render() {
		$this->canvas = $this->objectManager->get(CanvasInterface::class);
		$this->canvas->setBaseImageResource($this->arguments['imageResource']);
		$this->canvas->setAlternativeText($this->getTitleText());

		return $this->canvas->render();
	}

	/**
	 * @return string
	 */
	private function getTitleText() {
		if ('' !== trim($this->arguments['titleText'])) {
			$titleText = $this->arguments['titleText'];
		} else {
			$titleText = $this->arguments['titleTextAlternative'];
		}

		return $titleText;
	}
}
