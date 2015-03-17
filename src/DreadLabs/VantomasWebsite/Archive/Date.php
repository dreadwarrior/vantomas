<?php
namespace DreadLabs\VantomasWebsite\Archive;

class Date {

	/**
	 * @var \DateTime
	 */
	protected $date;

	/**
	 * @param \DateTime $date
	 */
	public function __construct(\DateTime $date) {
		$this->date = $date;
	}

	/**
	 * @return \DateTime
	 */
	public function getValue() {
		return $this->date;
	}
}