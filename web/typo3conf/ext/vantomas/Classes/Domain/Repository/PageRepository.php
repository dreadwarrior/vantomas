<?php
namespace DreadLabs\Vantomas\Domain\Repository;

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

use DreadLabs\Vantomas\Domain\Page\FactoryInterface;
use DreadLabs\VantomasWebsite\Archive\SearchInterface;
use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\Page\PageId;
use DreadLabs\VantomasWebsite\Page\PageRepositoryInterface;
use DreadLabs\VantomasWebsite\Page\PageType;
use DreadLabs\VantomasWebsite\RssFeed\ConfigurationInterface as RssFeedConfigurationInterface;
use DreadLabs\VantomasWebsite\Sitemap\ConfigurationInterface as SitemapConfigurationInterface;
use DreadLabs\VantomasWebsite\Taxonomy\Tag;
use TYPO3\CMS\Core\Database\PreparedStatement;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * PageRepository gives low level access to pages records
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PageRepository extends Repository implements PageRepositoryInterface
{

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param FactoryInterface $factory
     *
     * @return void
     */
    public function injectFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }


    /**
     * Searches for archived (page) nodes by given criteria
     *
     * @param SearchInterface $search Archive search impl
     *
     * @return Page[]
     */
    public function findArchived(SearchInterface $search)
    {
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
            $this->objectManager->get(PreparedStatement::class, $sql, 'pages'),
            $search->getCriteria()
        );
        $rawResults = $query->execute(true);

        return $this->hydrate($rawResults);
    }

    /**
     * Hydrates the given raw results
     *
     * @param array $rawResults Raw result list
     *
     * @return Page[]
     */
    private function hydrate(array $rawResults)
    {
        $pages = [];

        array_walk($rawResults, function ($rawResult) use (&$pages) {
            $pages[] = $this->factory->createFromAssociativeArray($rawResult);
        });

        return $pages;
    }

    /**
     * Finds last updated pages of type $pageType
     *
     * @param PageType $pageType PageType to query
     * @param int $offset Start here
     * @param int $limit Limit to this
     *
     * @return Page[]
     */
    public function findLastUpdated(PageType $pageType, $offset = 0, $limit = 1)
    {
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
                AND deleted = 0
                AND hidden = 0
            ORDER BY
                lastUpdated DESC
            LIMIT ' . $offset . ', ' . $limit . '
        ';

        $query->statement(
            $this->objectManager->get(PreparedStatement::class, $sql, 'pages'),
            [
                $pageType->getValue(),
            ]
        );
        $rawResults = $query->execute(true);

        return $this->hydrate($rawResults);
    }

    /**
     * Finds one page by uid
     *
     * @param int $uid The PageId
     *
     * @return \DreadLabs\Vantomas\Domain\Model\Page
     */
    public function findOneByUid($uid)
    {
        $query = $this->createQuery();

        $query->getQuerySettings()->setRespectStoragePage(false);

        $query->matching(
            $query->equals('uid', $uid)
        );

        return $query->setLimit(1)->execute()->getFirst();
    }

    /**
     * Finds all pages with tags
     *
     * @return Page[]
     */
    public function findAllWithTags()
    {
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
        $rawResults = $query->execute(true);

        return $this->hydrate($rawResults);
    }

    /**
     * Finds all pages by given Tag
     *
     * @param Tag $tag Search pages with this tag
     *
     * @return Page[]
     */
    public function findAllByTag(Tag $tag)
    {
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
            $this->objectManager->get(PreparedStatement::class, $sql, 'pages'),
            [
                ',%' . $tag->getValue() . '%,',
                '%' . $tag->getValue() . '%,',
                ',%' . $tag->getValue() . '%',
                '%' . $tag->getValue() . '%',
            ]
        );
        $rawResults = $query->execute(true);

        return $this->hydrate($rawResults);
    }

    /**
     * Finds all pages for the RSS Feed
     *
     * @param RssFeedConfigurationInterface $configuration RssFeed configuration impl
     *
     * @return Page[]
     */
    public function findAllForRssFeed(RssFeedConfigurationInterface $configuration)
    {
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
                AND deleted != 1
                AND hidden != 1
        ';

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

        $sql .= '
            ORDER BY
                ' . $configuration->getOrderBy() . ' ' . $configuration->getOrderDirection() . '
        ';

        $query->statement($sql);
        $rawResults = $query->execute(true);

        return $this->hydrate($rawResults);
    }

    /**
     * Finds all pages for sitemap.xml generation
     *
     * @param SitemapConfigurationInterface $configuration Sitemap configuration impl
     *
     * @return Page[]
     */
    public function findForSitemapXml(SitemapConfigurationInterface $configuration)
    {
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
                        function (PageId $pageId) {
                            return $pageId->getValue();
                        },
                        $configuration->getParentPageIds()->toArray()
                    )
                ) . ')
                AND uid NOT IN (' . implode(
                    ', ',
                    array_map(
                        function (PageId $pageId) {
                            return $pageId->getValue();
                        },
                        $configuration->getExcludePageIds()->toArray()
                    )
                ) . ')
        ';

        $query->statement($sql);
        $rawResults = $query->execute(true);

        return $this->hydrate($rawResults);
    }
}
