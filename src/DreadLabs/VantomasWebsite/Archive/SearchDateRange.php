<?php
namespace DreadLabs\VantomasWebsite\Archive;

class SearchDateRange {

	/**
	 *
	 * @var \DateTime
	 */
	protected $startDate;

	/**
	 *
	 * @var \DateTime
	 */
	protected $endDate;

	/**
	 * Constructs the archive search DateRange
	 *
	 * @param integer $month
	 * @param integer $year
	 */
	public function __construct($month, $year) {
		$this->startDate = new \DateTime();
		$this->startDate->setDate($year, $month, 1);
		$this->startDate->setTime(0, 0, 0);

		$interval = new \DateInterval('P1M');

		$this->endDate = clone $this->startDate;
		$this->endDate->add($interval);
	}

	/**
	 * Returns the start date
	 *
	 * @return \DateTime
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * Returns the end date
	 *
	 * @return \DateTime
	 */
	public function getEndDate() {
		return $this->endDate;
	}
}