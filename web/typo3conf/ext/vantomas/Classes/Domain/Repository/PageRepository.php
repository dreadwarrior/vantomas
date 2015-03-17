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
use DreadLabs\VantomasWebsite\Page\Tag;
use TYPO3\CMS\Extbase\Persistence\Repository;
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

			// page statistics
			$page->setSubTitle($rawResult['subtitle']);
			$page->setKeywords($rawResult['keywords']);

			$pages[] = $page;
		}

		return $pages;
	}

	/**
	 * {@inheritdoc}
	 */
	public function findLastUpdated(PageId $parentPageId, $offset = 0, $limit = 1) {
		$query = $this->createQuery();

		$sql = '
			SELECT
				*
			FROM
				pages
			WHERE
				pid = ?
				AND nav_hide = 0
				AND deleted = 0
				AND hidden = 0
			ORDER BY
				lastUpdated DESC
			LIMIT ' . $offset . ', ' . $limit . '
		';

		$query->statement(
			$sql,
			array(
				$parentPageId->getValue(),
			)
		);
		$rawResults = $query->execute(TRUE);

		return $this->hydrate($rawResults);
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
	 * {@inheritdoc}
	 */
	public function findAllWithTags() {
		$query = $this->createQuery();

		$sql = "
			SELECT
				*
			FROM
				pages
			WHERE
				nav_hide = 0
				AND deleted = 0
				AND hidden = 0
				AND keywords IS NOT NULL
				AND keywords <> ''
		";

		$query->statement($sql);
		$rawResults = $query->execute(TRUE);

		return $this->hydrate($rawResults);
	}

	/**
	 * {@inheritdoc}
	 */
	public function findAllByTag(Tag $tag) {
		$query = $this->createQuery();

		$sql = "
			SELECT
				*
			FROM
				pages
			WHERE
				nav_hide = 0
				AND deleted = 0
				AND hidden = 0
				AND keywords IS NOT NULL
				AND keywords <> ''
				AND (
					keywords LIKE ?
					OR keywords LIKE ?
					OR keywords LIKE ?
					OR keywords LIKE ?
				)
		";
		$query->statement(
			$sql,
			array(
				',%' . $tag->getValue() . '%,',
				'%' . $tag->getValue() . '%,',
				',%' . $tag->getValue() . '%',
				'%' . $tag->getValue() . '%',
			)
		);
		$rawResults = $query->execute(TRUE);

		return $this->hydrate($rawResults);
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
	 * {@inheritdoc}
	 */
	public function findForSitemapXml($parentPageIds, $excludePageIds) {
		$query = $this->createQuery();

		$sql = "
			SELECT
				*
			FROM
				pages
			WHERE
				nav_hide != 1
				AND deleted = 0
				AND hidden = 0
				AND pid IN (" . implode(', ', array_map(function(PageId $pageId) {
					return $pageId->getValue();
				}, $parentPageIds)) . ")
				AND uid NOT IN (" . implode(', ', array_map(function(PageId $pageId) {
					return $pageId->getValue();
				}, $excludePageIds)) . ")

		";

		$query->statement($sql);
		$rawResults = $query->execute(TRUE);

		return $this->hydrate($rawResults);
	}
}