<?php
class Tx_Vantomas_Domain_Repository_CommentRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * 
	 * @var t3lib_queryGenerator
	 */
	protected $queryGenerator = NULL;

	/**
	 * 
	 * @param t3lib_queryGenerator $queryGenerator
	 * @return void
	 */
	public function injectQueryGenerator(t3lib_queryGenerator $queryGenerator) {
		$this->queryGenerator = $queryGenerator;
	}

	/**
	 * 
	 * @param integer $storagePid
	 * @param integer $limit
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Vantomas_Domain_Model_Comment>
	 */
	public function getLatestComments($storagePid, $limit = 5) {
		$treePids = $this->queryGenerator->getTreeList($storagePid, 1, 0, 1);

		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->logicalAnd(
				$query->in('pid', explode(',', $treePids)),
				$query->equals('approved', 1)
			)
		);

		$query->setOrderings(array(
			'crdate' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING
		));

		$query->setLimit($limit);

		$comments = $query->execute();

		return $comments;
	}
}
?>