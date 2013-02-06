<?php
/**
 * @NOTE: Maybe switch to ValueObject could help to get a correct domain model object instance
 * while querying via repo
 *
 * @author tjuhnke
 *
 */
class Tx_Vantomas_Domain_Model_GenericCounter extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * @var int
	 * @validate NotEmpty
	 */
	protected $counterId;

	/**
	 * @var int
	 * @validate NotEmpty
	 */
	protected $numberOfVisits;

	/**
	 * @var int
	 * @validate NotEmpty
	 */
	protected $timestamp;

	/**
	 *
	 * @param integer $counterId
	 * @return void
	 * @api
	 */
	public function setCounterId($counterId) {
		$this->counterId = $counterId;
	}

	/**
	 *
	 * @return integer
	 * @api
	 */
	public function getCounterId() {
		return $this->counterId;
	}

	/**
	 *
	 * @param integer $numberOfVisits
	 * @return void
	 * @api
	 */
	public function setNumberOfVisits($numberOfVisits) {
		$this->numberOfVisits = $numberOfVisits;
	}

	/**
	 *
	 * @return integer
	 * @api
	 */
	public function getNumberOfVisits() {
		return $this->numberOfVisits;
	}

	/**
	 *
	 * @param integer $timestamp
	 * @return void
	 * @api
	 */
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
	}

	/**
	 *
	 * @return integer
	 * @api
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}
}
?>
