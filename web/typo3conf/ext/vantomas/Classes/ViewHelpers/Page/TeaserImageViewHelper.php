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

use DreadLabs\VantomasWebsite\Media\Identifier;
use DreadLabs\VantomasWebsite\Media\StorageInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A page teaser image generator view helper which makes use of TypoScript cObj
 * IMAGE & GIFBUILDER configuration.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TeaserImageViewHelper extends AbstractViewHelper {

	/**
	 * @var string
	 */
	const WIDTH = '546';

	/**
	 * @var string
	 */
	const HEIGHT = '171';

	/**
	 * @var StorageInterface
	 */
	private $storage;

	/**
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	protected $contentObject;

	/**
	 * @param StorageInterface $storage
	 * @param ConfigurationManagerInterface $configurationManager
	 */
	public function __construct(
		StorageInterface $storage,
		ConfigurationManagerInterface $configurationManager
	) {
		$this->storage = $storage;

		$this->contentObject = $configurationManager->getContentObject();
	}

	/**
	 * Initializes the VH arguments
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('imageResource', 'string', 'The image resource. A CSV list of media resources.', TRUE);
		$this->registerArgument('titleText', 'string', 'Title text', FALSE);
		$this->registerArgument('titleTextAlternative', 'string', 'Title text fallback/alternative', FALSE);
	}

	/**
	 * Renders the VH
	 *
	 * @return string ready-to-use <img />-Tag
	 */
	public function render() {
		$baseImageResource = $this->getBaseImageResource();

		$conf = array(
			'file' => 'GIFBUILDER',
			'file.' => array(
				'XY' => '[10.w],[10.h]',

				'10' => 'IMAGE',
				'10.' => array(
					'file' => $baseImageResource,
					'file.' => array(
						'width' => self::WIDTH . 'm',
						'height' => self::HEIGHT . 'c',
						'minW' => self::WIDTH,
					),
				),

				'20' => 'IMAGE',
				'20.' => array(
					'file' => 'EXT:vantomas/Resources/Public/Images/folded-paper.png',
					'file.' => array(
						'width' => self::WIDTH . 'm',
						'minW' => self::WIDTH,
					),
				),

				'30' => 'IMAGE',
				'30.' => array(
					'file' => 'EXT:vantomas/Resources/Public/Images/grunge.png',
					'offset' => '0,-5',
				),
			),

			'altText' => $this->getAlternativeText(),
			'titleText' => $this->getTitleText(),
		);

		return $this->contentObject->cObjGetSingle('IMAGE', $conf);
	}

	/**
	 * Returns the base image resource
	 *
	 * @return string
	 */
	protected function getBaseImageResource() {
		$ressource = '';

		if ('' === $this->arguments['imageResource']) {
			return $ressource;
		}

		$fileIdentifiers = explode(',', $this->arguments['imageResource']);
		$fileIdentifier = $this->objectManager->get(Identifier::class, $fileIdentifiers[0]);

		return $this->storage->getPublicPath($fileIdentifier);
	}

	/**
	 * @return string
	 */
	private function getAlternativeText() {
		if ('' !== trim($this->arguments['titleText'])) {
			$alternativeText = $this->arguments['titleText'];
		} else {
			$alternativeText = $this->arguments['titleTextAlternative'];
		}

		return $alternativeText;
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