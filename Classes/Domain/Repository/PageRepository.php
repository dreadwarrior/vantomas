<?php
class Tx_Vantomas_Domain_Repository_PageRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 *
	 * @var Tx_Vantomas_Domain_Repository_GenericCounterRepository
	 */
	protected $genericCounterRepository = NULL;

	/**
	 *
	 * @param Tx_Vantomas_Domain_Repository_GenericCounterRepository $genericCounterRepository
	 * @return void
	 */
	public function injectGenericCounterRepository(Tx_Vantomas_Domain_Repository_GenericCounterRepository $genericCounterRepository) {
		$this->genericCounterRepository = $genericCounterRepository;
	}

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

	/**
	 *
	 * @param integer $storagePid
	 * @param integer $limit
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Vantomas_Domain_Model_Page>
	 */
	public function findMostPopularPages($storagePid, $limit = 5) {
		$genericCounters = $this->genericCounterRepository->findHighestVisits($limit);

		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		// build an OR ($query->logicalOr()) with a contains for every record
		$pidConstraints = array();

		foreach ($genericCounters as $genericCounter) {
			$pidConstraints[] = $query->equals('uid', $genericCounter['cid']/*->getCounterId() */);
		}

		$query->matching(
			$query->logicalAnd(
				$query->equals('pid', $storagePid),
// 				$query->in('uid', $pidConstraints)
				$query->logicalOr($pidConstraints)
			)
		);

// 		$query->setOrderings(array(
// 			'FIELD("uid", "' . implode('","', $ordering) . '")' => ''
// 		));

		$pages = $query->execute();

		$sortedPages = array();

		foreach ($genericCounters as $genericCounter) {
			$sortedPages[] = $this->sortMostPopularPages($pages, $genericCounter['cid']);
		}

		return $sortedPages;

		// @see http://forge.typo3.org/issues/10212
// 		$query = $this->createQuery();
// 		$qomFactory = Tx_Extbase_Dispatcher::getPersistenceManager()->getBackend()->getQomFactory();

// 		$selectorA = $qomFactory->selector(null, 'tx_extension_domain_model_a');
// 		$mmSelector = $qomFactory->selector(null, 'tx_extension_b_a_mm');
// 		$selectorB = $query->getSource();

// 		$AMMJoinCondition = $qomFactory->equiJoinCondition(
// 			$mmSelector->getSelectorName(), 'uid_foreign',
// 			$selectorA->getSelectorName(), 'uid'
// 		);

// 		$MMBJoinCondition = $qomFactory->equiJoinCondition(
// 			$selectorB->getSelectorName(), 'uid',
// 			$mmSelector->getSelectorName(), 'uid_local'
// 		);

// 		$query->setSource(
// 			$qomFactory->join(
// 				$selectorA,
// 				$qomFactory->join(
// 					$mmSelector,
// 					$selectorB,
// 					Tx_Extbase_Persistence_QueryInterface::JCR_JOIN_TYPE_INNER,
// 					$MMBJoinCondition
// 				),
// 				Tx_Extbase_Persistence_QueryInterface::JCR_JOIN_TYPE_INNER,
// 				$AMMJoinCondition
// 			)
// 		);

// 		return $query->execute();

		/*
		SELECT
			tx_extension_domain_model_b.*
		FROM
			tx_extension_domain_model_a tx_extension_b_a_mm
			LEFT JOIN
				tx_extension_b_a_mm ON
					tx_extension_b_a_mm.uid_foreign = tx_extension_domain_model_a.uid
						LEFT JOIN
							tx_extension_domain_model_b ON
								tx_extension_domain_model_b.uid = tx_extension_b_a_mm.uid_local
		WHERE
			tx_extension_domain_model_b.deleted=0
			AND tx_extension_domain_model_b.hidden=0
			AND tx_extension_domain_model_b.pid IN (11, 0)
		 */
	}

	// @see http://blog.schreibersebastian.de/2011/07/sortierung-anhand-einer-csv-list/
	private function sortMostPopularPages($pages, $counterId) {
		foreach ($pages as $page) {
			if ($page instanceof Tx_Extbase_DomainObject_AbstractDomainObject) {
				$recordUid = $page->getUid();
			}
			if ((integer) $recordUid === (integer) $counterId) {
				return $page;
			}
		}
	}

	/**
	 *
	 * @param integer $storagePid
	 * @param integer $offset
	 */
	public function findLastUpdatedPage($storagePid, $offset = 0) {
		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->equals('pid', $storagePid)
		);

		$query->setOffset($offset);

		$query->setLimit(1);

		$query->setOrderings(array(
			'lastUpdated' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING
		));

		$pages = $query->execute();

		return $pages->getFirst();
	}
}
?>