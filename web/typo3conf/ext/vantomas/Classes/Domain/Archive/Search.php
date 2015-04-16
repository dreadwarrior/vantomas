<?php
namespace DreadLabs\Vantomas\Domain\Archive;

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

use DreadLabs\VantomasWebsite\Archive\DateRange;
use DreadLabs\VantomasWebsite\Archive\SearchInterface;
use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\Page\PageType;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Archive search impl
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Search implements SearchInterface {

	/**
	 * @var TypoScriptFrontendController
	 */
	private $typoScriptFrontendController;

	/**
	 * @var Page[]
	 */
	private $result;

	/**
	 * @var DateRange
	 */
	private $dateRange;

	/**
	 * @var PageType
	 */
	private $pageType;

	/**
	 * @return self
	 */
	public function __construct() {
		$this->typoScriptFrontendController = $GLOBALS['TSFE'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator() {
		return new \ArrayIterator($this->result);
	}

	/**
	 * {@inheritdoc}
	 */
	public function count() {
		return count($this->result);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDateRange(DateRange $dateRange) {
		$this->dateRange = $dateRange;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setPageType(PageType $pageType) {
		$this->pageType = $pageType;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setResult(array $result) {
		$this->result = $result;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCurrentPage() {
		return $this->typoScriptFrontendController->page;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCriteria() {
		return array(
			$this->pageType->getValue(),
			$this->dateRange->getStartDate()->getTimestamp(),
			$this->dateRange->getEndDate()->getTimestamp(),
		);
	}

	public function getResultListTitleArguments() {
		return array(
			$this->dateRange->getStartDate()->format('Y'),
			$this->dateRange->getStartDate()->format('m'),
		);
	}
}