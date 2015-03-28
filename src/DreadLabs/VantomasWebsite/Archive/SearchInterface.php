<?php
namespace DreadLabs\VantomasWebsite\Archive;

use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\Page\PageType;

interface SearchInterface extends \IteratorAggregate, \Countable {

	/**
	 * @param DateRange $dateRange
	 * @return void
	 */
	public function setDateRange(DateRange $dateRange);

	/**
	 * @param PageType $pageType
	 * @return void
	 */
	public function setPageType(PageType $pageType);

	/**
	 * @param Page[] $result
	 * @return void
	 */
	public function setResult(array $result);

	/**
	 * @return array
	 */
	public function getCurrentPage();

	/**
	 * @return array
	 */
	public function getCriteria();

	/**
	 * List of arguments for a result list title generation.
	 *
	 * The result list title may contain placeholders for the
	 * date range month / year values, parsed by sprintf() or
	 * similar.
	 *
	 * @return array
	 */
	public function getResultListTitleArguments();
}