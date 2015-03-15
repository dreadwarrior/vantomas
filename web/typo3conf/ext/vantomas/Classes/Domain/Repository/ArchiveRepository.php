<?php
namespace DreadLabs\Vantomas\Domain\Repository;

use DreadLabs\VantomasWebsite\Archive\PageInterface;
use DreadLabs\VantomasWebsite\Archive\RepositoryInterface;
use DreadLabs\VantomasWebsite\Archive\SearchDateRange;
use Dreadlabs\VantomasWebsite\ValueObject\PageId;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ArchiveRepository extends Repository implements RepositoryInterface {

	/**
	 * Finds content [page] nodes grouped by month per year
	 *
	 * Useful for an archive list.
	 *
	 * @param PageId $parentPageId
	 * @return PageInterface[]
	 */
	public function findGroupedByMonthPerYear(PageId $parentPageId) {
		$query = $this->createQuery();

		// circumvents 'AND pid IN ()' in query string
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->logicalAnd(
				$query->equals('pid', $parentPageId->getValue()),
				$query->equals('hideInNavigation', 0)
			)
		);

		$query->setOrderings(array(
			'lastUpdated' => QueryInterface::ORDER_DESCENDING
		));

		$pages = $query->execute();

		return $pages;
	}

	/**
	 * Searches for archived content [page] nodes by given criteria
	 *
	 * @param PageId $parentPageId
	 * @param SearchDateRange $dateRange
	 * @return PageInterface[]
	 */
	public function search(PageId $parentPageId, SearchDateRange $dateRange) {
		// TODO: Implement search() method.
	}
}