<?php
namespace DreadLabs\Vantomas\ViewHelpers\Page;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (tommy@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * A page teaser image generator view helper which makes use of TypoScript cObj
 * IMAGE & GIFBUILDER configuration.
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class TeaserImageViewHelper extends AbstractViewHelper {

	const BASE_PATH_BELOW_SIXPOINTZERO = 'uploads/media/';

	const WIDTH = '546';

	const HEIGHT = '171';

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	protected $contentObject;

	/**
	 * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
		$this->contentObject = $this->configurationManager->getContentObject();
	}

	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('imageRessource', 'string', 'The image ressource. A CSV list of media ressources.', TRUE);
		$this->registerArgument('titleText', 'string', 'Title text', FALSE);
		$this->registerArgument('titleTextAlternative', 'string', 'Title text fallback/alternative', FALSE);
	}

	/**
	 *
	 * @return string ready-to-use <img />-Tag
	 */
	public function render() {
		$baseImageRessource = $this->getBaseImageRessource();

		$conf = array(
			'file' => 'GIFBUILDER',
			'file.' => array(
				'XY' => '[10.w],[10.h]',

				'10' => 'IMAGE',
				'10.' => array(
					'file' => $baseImageRessource,
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

			'altText' => '' !== $this->arguments['titleText'] ? $this->arguments['titleText'] : $this->arguments['titleTextAlternative'],
			'titleText' => '' !== $this->arguments['titleText'] ? $this->arguments['titleText'] : $this->arguments['titleTextAlternative'],
		);

		return $this->contentObject->IMAGE($conf);
	}

	protected function getBaseImageRessource() {
		$ressource = '';

		$ressource = $this->getBaseImageRessourceFal();

		return $ressource;
	}

	protected function getBaseImageRessourceFal() {
		$ressource = '';

		if ('' !== $this->arguments['imageRessource']) {
			$fileIdentifiers = explode(',', $this->arguments['imageRessource']);

			$fileIdentifier = $fileIdentifiers[0];

			/* @var $storageRepository \TYPO3\CMS\Core\Resource\StorageRepository */
			$storageRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');

			// /fileadmin
			/* @var $storage \TYPO3\CMS\Core\Resource\ResourceStorage */
			$storage = $storageRepository->findByUid(1);

			/* @var $fileObject \TYPO3\CMS\Core\Resource\FileInterface */
			$fileObject = $storage->getFile($fileIdentifier);

			$ressource = $fileObject->getPublicUrl();
		}

		return $ressource;
	}
}
?>