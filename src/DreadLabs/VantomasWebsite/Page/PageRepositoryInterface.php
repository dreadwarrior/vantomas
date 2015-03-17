<?php
namespace Dreadlabs\VantomasWebsite\Page;

use DreadLabs\VantomasWebsite\Archive\SearchDateRange;

interface PageRepositoryInterface {

	/**
	 * Searches for archived (page) nodes by given criteria
	 *
	 * @param PageId $parentPageId
	 * @param SearchDateRange $dateRange
	 * @return PageInterface[]
	 */
	public function findArchived(PageId $parentPageId, SearchDateRange $dateRange);
}