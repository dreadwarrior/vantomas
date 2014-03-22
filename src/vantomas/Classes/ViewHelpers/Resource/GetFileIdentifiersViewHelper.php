<?php
namespace DreadLabs\Vantomas\ViewHelpers\Resource;

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
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * GetFileIdentifiersViewHelper returns a CSV list of \TYPO3\CMS\Resource\FileInterface public urls
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class GetFileIdentifiersViewHelper extends AbstractViewHelper {

	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('table', 'string', 'Name of the table to fetch file identifiers for.', TRUE);
		$this->registerArgument('field', 'string', 'Name of the field to fetch file identifiers for.', TRUE);
		$this->registerArgument('uid', 'integer', 'UID of the row in table.', TRUE);
	}

	public function render() {
		$fileIdentifiers = array();

		$fileRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');

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
?>