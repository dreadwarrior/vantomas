<?php
namespace DreadLabs\Vantomas\Domain\Repository;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Thomas Juhnke (typo3@van-tomas.de)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\VantomasWebsite\Archive\SearchDateRange;
use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\Page\PageId;
use DreadLabs\VantomasWebsite\Page\PageRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use DreadLabs\Vantomas\Domain\Model\RssConfiguration;

/**
 * PageRepository gives low level access to pages records
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PageRepository extends Repository implements PageRepositoryInterface {

	/**
	 * {@inheritdoc}
	 */
	public function findArchived(PageId $parentPage, SearchDateRange $dateRange) {
		$query = $this->createQuery();

		$sql = '
			SELECT
				*,
				FROM_UNIXTIME(lastUpdated) as last_updated_at
			FROM
				pages
			WHERE
				pid = ?
				AND nav_hide = 0
				AND deleted = 0
				AND hidden = 0
				AND (
					lastUpdated >= ?
					AND lastUpdated < ?
				)
			ORDER BY
				lastUpdated DESC
		';

		$query->statement(
			$sql,
			array(
				$parentPage->getValue(),
				$dateRange->getStartDate()->getTimestamp(),
				$dateRange->getEndDate()->getTimestamp()
			)
		);
		$rawResults = $query->execute(TRUE);

		return $this->hydrate($rawResults);
	}

	/**
	 * @param array $rawResults
	 * @return Page[]
	 */
	private function hydrate(array $rawResults) {
		$pages = array();

		foreach ($rawResults as $rawResult) {
			$pageId = new PageId($rawResult['uid']);

			$page = new Page($pageId);
			$page->setTitle($rawResult['title']);
			$page->setLastUpdatedAt(new \DateTime($rawResult['last_updated_at']));
			$page->setAbstract($rawResult['abstract']);

			$pages[] = $page;
		}

		return $pages;
	}

	/**
	 * Finds the last updated pages
	 *
	 * @param integer $storagePid
	 * @param integer $offset
	 * @param integer $limit
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DreadLabs\Vantomas\Domain\Model\Page>
	 */
	public function findLastUpdated($storagePid, $offset = 0, $limit = 1) {
		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->equals('pid', $storagePid)
		);

		$query->setOffset($offset - 1);

		$query->setLimit($limit);

		$query->setOrderings(array(
			'lastUpdated' => QueryInterface::ORDER_DESCENDING
		));

		$pages = $query->execute();

		return $pages;
	}

	/**
	 * Finds one page by uid
	 *
	 * @param integer $uid
	 * @return \DreadLabs\Vantomas\Domain\Model\Page
	 */
	public function findOneByUid($uid) {
		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->equals('uid', $uid)
		);

		return $query->setLimit(1)->execute()->getFirst();
	}

	/**
	 * Finds all pages with tags
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface<\DreadLabs\Vantomas\Domain\Model\Page>
	 */
	public function findAllWithTags() {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->logicalAnd(
				$query->logicalNot(
					$query->equals('keywords', NULL)
				),
				$query->logicalNot(
					$query->equals('keywords', '')
				)
			)
		);

		return $query->execute();
	}

	/**
	 * Finds all pages with given $tag
	 *
	 * @param string $tag
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface<\DreadLabs\Vantomas\Domain\Model\Page>
	 */
	public function findAllByTag($tag) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$tagConstraints = array(
			$query->like('keywords', ',%' . $tag . '%,'),
			$query->like('keywords', '%' . $tag . '%,'),
			$query->like('keywords', ',%' . $tag . '%'),
			$query->like('keywords', '%' . $tag . '%'),
		);

		$query->matching(
			$query->logicalAnd(
				$query->logicalOr(
					$query->logicalNot(
						$query->equals('keywords', NULL)
					),
					$query->logicalNot(
						$query->equals('keywords', '')
					)
				),
				$query->logicalOr(
					$tagConstraints
				)
			)
		);

		return $query->execute();
	}

	/**
	 * Finds all pages for RSS feed
	 *
	 * @param RssConfiguration $rssConfiguration
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface<\DreadLabs\Vantomas\Domain\Model\Page>
	 */
	public function findAllForRssFeed(RssConfiguration $rssConfiguration) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$constraints = array();

		$constraints[] = $query->logicalNot(
			$query->equals('hideInNavigation', 1)
		);

		//$constraints[] = $query->equals('excludeFromRss', 0);
		if ($rssConfiguration->hasTreeListPageIds()) {
			$constraints[] = $query->in('uid', $rssConfiguration->getTreeListPageIds());
		}
		if ($rssConfiguration->hasDoktypes()) {
			$constraints[] = $query->in('doktype', $rssConfiguration->getDoktypes());
		}


		$query->matching(
			$query->logicalAnd(
				$constraints
			)
		);

		$query->setOrderings(
			$rssConfiguration->getOrderings()
		);

		if ($rssConfiguration->hasLimit()) {
			$query->setLimit($rssConfiguration->getLimit());
		}

		return $query->execute();
	}

	/**
	 * Finds all pages for sitemap.xml generation
	 *
	 * @param array $pids
	 * @param array $excludeUids
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findForSitemapXml($pids, $excludeUids) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$constraints = array();
		$constraints[] = $query->in('pid', $pids);
		$constraints[] = $query->logicalNot(
			$query->in('uid', $excludeUids)
		);
		$constraints[] = $query->logicalNot(
			$query->equals('hideInNavigation', 1)
		);

		$query->matching(
			$query->logicalAnd(
				$constraints
			)
		);

		return $query->execute();
	}
}