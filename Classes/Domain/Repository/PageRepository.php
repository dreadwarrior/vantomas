<?php
class Tx_Vantomas_Domain_Repository_PageRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 *
	 * @param integer $storagePid
	 * @return Tx_Vantomas_Domain_Model_Page
	 */
	public function findByStoragePidOrderedDescendingByLastUpdated($storagePid) {
		$query = $this->createQuery();

		// circumvents 'AND pid IN ()' in query string
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->logicalAnd(
				$query->equals('pid', $storagePid),
				$query->equals('hideInNavigation', 0)
			)
		);

		$query->setOrderings(array(
			'lastUpdated' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING
		));

		$pages = $query->execute();

		return $pages;
	}

	/**
	 *
	 * @param integer $storagePid
	 * @param integer $month
	 * @param integer $year
	 * @return Tx_Vantomas_Domain_Model_Page[]
	 */
	public function findByStoragePidOrderedDescendingByLastUpdatedInAGivenMonth($storagePid, $month, $year) {
		/*
		'pidInList' => $storagePid,
		'orderBy' => 'lastUpdated DESC',
		'andWhere' => sprintf("lastUpdated BETWEEN UNIX_TIMESTAMP('%s-%s-01 00:00:01') AND UNIX_TIMESTAMP(CONCAT(LAST_DAY('%s-%s-01'), ' 23:59:59'))",
			$requestVars['year'],
			$requestVars['month'],
			$requestVars['year'],
			$requestVars['month']
		)
		*/

		$firstDayOfIncomingMonthTimestamp = mktime(0, 0, 1, $month, 1, $year);
		$lastDayOfIncomingMonthTimestamp = mktime(23, 59, 59, $month + 1, 0, $year);

		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->logicalAnd(
				$query->equals('pid', $storagePid),
				$query->logicalAnd(
					$query->greaterThanOrEqual('lastUpdated', $firstDayOfIncomingMonthTimestamp),
					$query->lessThanOrEqual('lastUpdated', $lastDayOfIncomingMonthTimestamp)
				)
			)
		);

		$query->setOrderings(array(
			'lastUpdated' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING
		));

		$pages = $query->execute();

		return $pages;
	}
}
?>