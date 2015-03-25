<?php
namespace DreadLabs\Vantomas\Archive;

use DreadLabs\VantomasWebsite\Archive\DateRange;
use DreadLabs\VantomasWebsite\Archive\SearchInterface;
use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\Page\PageId;
use Traversable;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class Search implements SearchInterface {

	/**
	 * @var TypoScriptFrontendController
	 */
	private $fe;

	/**
	 * @var Page[]
	 */
	private $result;

	/**
	 * @var DateRange
	 */
	private $dateRange;

	/**
	 * @var PageId
	 */
	private $parentPageId;

	public function __construct() {
		$this->fe = $GLOBALS['TSFE'];
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
	public function setParentPageId(PageId $pageId) {
		$this->parentPageId = $pageId;
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
		return $this->fe->page;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCriteria() {
		return array(
			$this->parentPageId->getValue(),
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