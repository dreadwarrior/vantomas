<?php
namespace DreadLabs\VantomasWebsite\Page;

use DreadLabs\VantomasWebsite\Archive\SearchDateRange;
use DreadLabs\VantomasWebsite\RssFeed\ConfigurationInterface as RssFeedConfigurationInterface;
use DreadLabs\VantomasWebsite\Sitemap\ConfigurationInterface as SitemapConfiguration;

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

	/**
	 * Finds all pages with tags
	 *
	 * @return Page[]
	 */
	public function findAllWithTags();

	/**
	 * @param Tag $tag
	 * @return Page[]
	 */
	public function findAllByTag(Tag $tag);

	/**
	 * @param SitemapConfiguration $configuration
	 * @return Page[]
	 */
	public function findForSitemapXml(SitemapConfiguration $configuration);


	/**
	 * @param RssFeedConfigurationInterface $configuration
	 * @return Page[]
	 */
	public function findAllForRssFeed(RssFeedConfigurationInterface $configuration);
}