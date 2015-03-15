<?php
namespace DreadLabs\VantomasWebsite\Archive;

use Dreadlabs\VantomasWebsite\ValueObject\PageId;

interface RepositoryInterface {

	/**
	 * Finds content [page] nodes grouped by month per year
	 *
	 * Useful for an archive list.
	 *
	 * @param PageId $parentPageId
	 * @return PageInterface[]
	 */
	public function findGroupedByMonthPerYear(PageId $parentPageId);

	/**
	 * Searches for archived content [page] nodes by given criteria
	 *
	 * @param PageId $parentPageId
	 * @param SearchDateRange $dateRange
	 * @return PageInterface[]
	 */
	public function search(PageId $parentPageId, SearchDateRange $dateRange);
}