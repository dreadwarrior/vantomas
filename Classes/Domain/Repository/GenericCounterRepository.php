<?php
class Tx_Vantomas_Domain_Repository_GenericCounterRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 *
	 * @param integer $limit
	 * @return array
	 */
	public function findHighestVisits($limit = 5) {
		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

		$query->statement('SELECT * FROM `tx_cscounterplus_info` ORDER BY visits DESC LIMIT ' . $limit);

		$genericCounters = $query->execute();

		return $genericCounters;
	}
}
?>
