<?php
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

/**
 * A page teaser image generator view helper which makes use of TypoScript cObj
 * IMAGE & GIFBUILDER configuration.
 *
 */
class Tx_Vantomas_ViewHelpers_Page_TeaserImageViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	const BASE_PATH_BELOW_SIXPOINTZERO = 'uploads/media/';

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
		$this->contentObject = $this->configurationManager->getContentObject();
	}

	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('imageRessource', 'string', 'The image ressource. A CSV list of media ressources or a CSV list of IDs if FAL is in use.', TRUE);
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
						'width' => '956m',
						'height' => '300c',
						'minW' => '956',
					),
				),

				'20' => 'IMAGE',
				'20.' => array(
					'file' => 'EXT:vantomas/Resources/Public/Images/folded-paper.png',
					'file.' => array(
						'width' => '956m',
						'minW' => '956',
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

		if (Tx_Flux_Utility_Version::assertCoreVersionIsBelowSixPointZero()) {
			$ressource = $this->getBaseImageRessourceDirect();
		} else {
			$ressource = $this->getBaseImageRessourceFal();
		}

		return $ressource;
	}

	protected function getBaseImageRessourceDirect() {
		$ressource = '';

		if ('' !== $this->arguments['imageRessource']) {
			$mediaItems = explode(',', $this->arguments['imageRessource']);

			$ressource = self::BASE_PATH_BELOW_SIXPOINTZERO . $mediaItems[0];
		}

		return $ressource;
	}

	protected function getBaseImageRessourceFal() {
		$ressource = '';

		if ('' !== $this->arguments['imageRessource']) {
			$fileIdentifiers = explode(',', $this->arguments['imageRessource']);

			$fileIdentifier = $fileIdentifiers[0];

			$storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');

			// /fileadmin
			$storage = $storageRepository->findByUid(1);

			$fileObject = $storage->getFile($fileIdentifier);

			$ressource = $fileObject->getPublicUrl();
		}

		return $ressource;
	}
}
?>
