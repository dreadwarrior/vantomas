<?php
namespace DreadLabs\Vantomas\ViewHelpers\Resource;

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

use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Returns a CSV list of \TYPO3\CMS\Resource\FileInterface public urls
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class GetFileIdentifiersViewHelper extends AbstractViewHelper {

	/**
	 * Initializes the VH arguments
	 *
	 * @return void
	 * @see AbstractViewHelper::initializeArguments()
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('table', 'string', 'Name of the table to fetch file identifiers for.', TRUE);
		$this->registerArgument('field', 'string', 'Name of the field to fetch file identifiers for.', TRUE);
		$this->registerArgument('uid', 'integer', 'UID of the row in table.', TRUE);
	}

	/**
	 * Renders the VH
	 *
	 * @return string
	 */
	public function render() {
		$fileIdentifiers = array();

		$fileRepository = GeneralUtility::makeInstance(FileRepository::class);

		$table = $this->arguments['table'];
		$field = $this->arguments['field'];
		$uid = MathUtility::convertToPositiveInteger($this->arguments['uid']);

		$fileObjects = $fileRepository->findByRelation($table, $field, $uid);

		foreach ($fileObjects as $file) {
			$fileIdentifiers[] = $file->getIdentifier();
		}

		return implode(',', $fileIdentifiers);
	}
}
