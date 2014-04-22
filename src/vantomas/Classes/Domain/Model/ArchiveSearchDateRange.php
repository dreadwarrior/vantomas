<?php
namespace DreadLabs\Vantomas\Domain\Model;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Tommy Juhnke <typo3@van-tomas.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * A DateRange DO for the archive search
 *
 * @package \DreadLabs\Vantomas\Domain\Model
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class ArchiveSearchDateRange extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject {

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
	 *
	 * @param integer $month
	 * @param integer $year
	 */
	public function __construct($month, $year) {
		$this->startDate = new \DateTime();
		$this->startDate->setDate($year, $month, 1);

		$interval = new \DateInterval('P1M');

		$this->endDate = clone $this->startDate;
		$this->endDate->add($interval);
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function getEndDate() {
		return $this->endDate;
	}
}
?>