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

use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
	 * @var ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	protected $contentObject;

	/**
	 * @param ConfigurationManagerInterface $configurationManager
	 */
	public function __construct(ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
		$this->contentObject = $this->configurationManager->getContentObject();
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

		return $this->contentObject->IMAGE($conf);
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
		$fileIdentifier = $fileIdentifiers[0];
		$fileObject = $this->getFileadminStorage()->getFile($fileIdentifier);

		$ressource = $fileObject->getPublicUrl();

		return $ressource;
	}

	/**
	 * @return null|\TYPO3\CMS\Core\Resource\ResourceStorage
	 */
	private function getFileadminStorage() {
		/* @var $storageRepository StorageRepository */
		$storageRepository = GeneralUtility::makeInstance(StorageRepository::class);

		return $storageRepository->findByUid(1);
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