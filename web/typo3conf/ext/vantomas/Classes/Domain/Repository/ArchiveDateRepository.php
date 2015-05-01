<?php
namespace DreadLabs\Vantomas\Domain\Repository;

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

use DreadLabs\VantomasWebsite\Archive\Date;
use DreadLabs\VantomasWebsite\Archive\DateRepositoryInterface;
use DreadLabs\VantomasWebsite\Page\PageType;
use TYPO3\CMS\Core\Database\PreparedStatement;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * ArchiveDate repository impl
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ArchiveDateRepository extends Repository implements DateRepositoryInterface {

	/**
	 * {@inheritdoc}
	 */
	public function find(PageType $pageType) {
		$query = $this->createQuery();

		$sql = "
			SELECT
				FROM_UNIXTIME(lastUpdated) as archive_date
			FROM
				pages
			WHERE
				doktype = ?
				AND deleted = 0
				AND hidden = 0
			GROUP BY
				DATE_FORMAT(FROM_UNIXTIME(lastUpdated), '%Y-%m')
			ORDER BY
				archive_date DESC
		";

		$query->statement(
			$this->objectManager->get(PreparedStatement::class, $sql, 'pages'),
			array(
				$pageType->getValue()
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
