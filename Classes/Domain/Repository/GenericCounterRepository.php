<?php
class Tx_Vantomas_Domain_Repository_GenericCounterRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 *
	 * @param integer $limit
	 * @return array
	 * // Tx_Extbase_Persistence_ObjectStorage<Tx_Vantomas_Domain_Model_GenericCounter>
	 */
	public function findHighestVisits($limit = 5, $rawResult = TRUE) {
		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		if ($rawResult) {
			$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

			$query->statement('SELECT * FROM `tx_cscounterplus_info` ORDER BY visits DESC LIMIT ' . $limit);
		} else {
			$query->setOrderings(array(
				'visits' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING
			));

			$query->setLimit($limit);
		}

		$genericCounters = $query->execute();

		return $genericCounters;
	}
}
?>