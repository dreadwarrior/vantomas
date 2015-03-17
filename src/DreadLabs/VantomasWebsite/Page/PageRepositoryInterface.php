<?php
namespace DreadLabs\VantomasWebsite\Page;

use DreadLabs\VantomasWebsite\Archive\SearchDateRange;

interface PageRepositoryInterface {

	/**
	 * Searches for archived (page) nodes by given criteria
	 *
	 * @param PageId $parentPageId
	 * @param SearchDateRange $dateRange
	 * @return Page[]
	 */
	public function findArchived(PageId $parentPageId, SearchDateRange $dateRange);

	/**
	 * Finds last updated pages within $parentPageId
	 *
	 * @param PageId $parentPageId
	 * @param int $offset
	 * @param int $limit
	 * @return Page[]
	 */
	public function findLastUpdated(PageId $parentPageId, $offset = 0, $limit = 1);
}