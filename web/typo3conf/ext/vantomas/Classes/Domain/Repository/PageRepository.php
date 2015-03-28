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

use DreadLabs\VantomasWebsite\Archive\SearchInterface;
use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\Page\PageId;
use DreadLabs\VantomasWebsite\Page\PageRepositoryInterface;
use DreadLabs\VantomasWebsite\Page\PageType;
use DreadLabs\VantomasWebsite\RssFeed\ConfigurationInterface as RssFeedConfigurationInterface;
use DreadLabs\VantomasWebsite\Sitemap\ConfigurationInterface as SitemapConfigurationInterface;
use DreadLabs\VantomasWebsite\Taxonomy\TagSearchInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * PageRepository gives low level access to pages records
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PageRepository extends Repository implements PageRepositoryInterface {

	/**
	 * {@inheritdoc}
	 */
	public function findArchived(SearchInterface $search) {
		$query = $this->createQuery();

		$sql = '
			SELECT
				*,
				FROM_UNIXTIME(crdate) as created_at,
				FROM_UNIXTIME(lastUpdated) as last_updated_at
			FROM
				pages
			WHERE
				doktype = ?
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
			$search->getCriteria()
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
			$page->setCreatedAt(new \DateTime($rawResult['created_at']));
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
				*,
				FROM_UNIXTIME(crdate) as created_at,
				FROM_UNIXTIME(lastUpdated) as last_updated_at
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
				*,
				FROM_UNIXTIME(crdate) as created_at,
				FROM_UNIXTIME(lastUpdated) as last_updated_at
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
	public function findAllByTag(TagSearchInterface $tagSearch) {
		$query = $this->createQuery();

		$sql = "
			SELECT
				*,
				FROM_UNIXTIME(crdate) as created_at,
				FROM_UNIXTIME(lastUpdated) as last_updated_at
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
				',%' . $tagSearch . '%,',
				'%' . $tagSearch . '%,',
				',%' . $tagSearch . '%',
				'%' . $tagSearch . '%',
			)
		);
		$rawResults = $query->execute(TRUE);

		return $this->hydrate($rawResults);
	}

	/**
	 * {@inheritdoc}
	 */
	public function findAllForRssFeed(RssFeedConfigurationInterface $configuration) {
		$query = $this->createQuery();

		$sql = '
			SELECT
				*,
				FROM_UNIXTIME(crdate) as created_at,
				FROM_UNIXTIME(lastUpdated) as last_updated_at
			FROM
				pages
			WHERE
				nav_hide != 1
		';

		if ($configuration->getPageIds()->count() > 0) {
			$sql .= '
				AND uid IN (' . implode(
					', ',
					array_map(
						function (PageId $pageId) {
							return $pageId->getValue();
						},
						$configuration->getPageIds()->toArray()
					)
				) . ')
			';
		}
		if ($configuration->getPageTypes()->count() > 0) {
			$sql .= '
				AND doktype IN (' . implode(
					', ',
					array_map(
						function (PageType $pageType) {
							return $pageType->getValue();
						},
						$configuration->getPageTypes()->toArray()
					)
				) . ')
			';
		}

		$ordering = $configuration->getOrdering();
		$sql .= '
			ORDER BY
				' . key($ordering) . ' ' . current($ordering) . '
		';

		$query->statement($sql);
		$rawResults = $query->execute(TRUE);

		return $this->hydrate($rawResults);
	}

	/**
	 * {@inheritdoc}
	 */
	public function findForSitemapXml(SitemapConfigurationInterface $configuration) {
		$query = $this->createQuery();

		$sql = '
			SELECT
				*,
				FROM_UNIXTIME(crdate) as created_at,
				FROM_UNIXTIME(lastUpdated) as last_updated_at
			FROM
				pages
			WHERE
				nav_hide != 1
				AND deleted = 0
				AND hidden = 0
				AND pid IN (' . implode(
					', ',
					array_map(
						function(PageId $pageId) {
							return $pageId->getValue();
						},
						$configuration->getParentPageIds()->toArray()
					)
				) . ')
				AND uid NOT IN (' . implode(
					', ',
					array_map(
						function(PageId $pageId) {
							return $pageId->getValue();
						},
						$configuration->getExcludePageIds()->toArray()
					)
			) . ')
		';

		$query->statement($sql);
		$rawResults = $query->execute(TRUE);

		return $this->hydrate($rawResults);
	}
}