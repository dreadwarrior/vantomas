<?php
namespace DreadLabs\Vantomas\Domain\Repository;

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Thomas Juhnke (typo3@van-tomas.de)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\VantomasWebsite\Archive\Date;
use DreadLabs\VantomasWebsite\Archive\DateRepositoryInterface;
use Dreadlabs\VantomasWebsite\Page\PageId;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ArchiveDateRepository extends Repository implements DateRepositoryInterface {

	/**
	 * {@inheritdoc}
	 */
	public function find(PageId $parentPageId) {
		$query = $this->createQuery();

		$sql = "
			SELECT
				FROM_UNIXTIME(lastUpdated) as archive_date
			FROM
				pages
			WHERE
				pid = ?
				AND nav_hide = 0
				AND deleted = 0
				AND hidden = 0
			GROUP BY
				DATE_FORMAT(FROM_UNIXTIME(lastUpdated), '%Y-%m')
			ORDER BY
				archive_date DESC
		";

		$query->statement(
			$sql,
			array(
				$parentPageId->getValue()
			)
		);

		$rawResults = $query->execute(TRUE);

		return $this->hydrate($rawResults);
	}

	/**
	 * @param array $rawResults
	 * @return Date[]
	 */
	private function hydrate(array $rawResults) {
		$result = array();

		foreach ($rawResults as $rawResult) {
			$result[] = new Date(new \DateTime($rawResult['archive_date']));
		}

		return $result;
	}
}