<?php
namespace DreadLabs\Vantomas\Domain\RssFeed;

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

use DreadLabs\VantomasWebsite\Page\PageType;
use DreadLabs\VantomasWebsite\Page\PageTypeCollectionInterface;
use DreadLabs\VantomasWebsite\RssFeed\ConfigurationInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * TypoScript configuration impl
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Configuration implements ConfigurationInterface {

	/**
	 * @var string
	 */
	private static $configurationRoot = 'rss';

	/**
	 * @var string
	 */
	private static $allowedOrderByFields = 'lastUpdated,sorting,title,subtitle,crdate,uid,starttime,endtime,newUntil,author,author_email';

	/**
	 * @var ConfigurationManagerInterface
	 */
	private $configurationManager;

	/**
	 * @var array
	 */
	private $settings;

	/**
	 * @var ContentObjectRenderer
	 */
	private $contentObject;

	/**
	 * @var PageTypeCollectionInterface
	 */
	private $pageTypes;

	/**
	 * @param ConfigurationManagerInterface $configurationManager
	 * @param PageTypeCollectionInterface $pageTypes
	 */
	public function __construct(
		ConfigurationManagerInterface $configurationManager,
		PageTypeCollectionInterface $pageTypes
	) {
		$this->configurationManager = $configurationManager;
		$this->contentObject = $this->configurationManager->getContentObject();
		$configuration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$this->settings = $configuration[self::$configurationRoot];

		$this->pageTypes = $pageTypes;
	}

	/**
	 * Returns the available/allowed doktypes
	 *
	 * @return array
	 */
	public function getPageTypes() {
		$pageTypes = isset($this->settings['doktypes']) ? $this->settings['doktypes'] : array(1);

		foreach ($pageTypes as $pageType) {
			$this->pageTypes->add(PageType::fromString($pageType));
		}

		return $this->pageTypes;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOrderBy() {
		$orderBy = 'lastUpdated';

		if (
			isset($this->settings['orderBy'])
			&& GeneralUtility::inList(self::$allowedOrderByFields, $this->settings['orderBy'])
		) {
			$orderBy = (string) $this->settings['orderBy'];
		}

		return $orderBy;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOrderDirection() {
		$orderDirection = QueryInterface::ORDER_DESCENDING;

		if (
			isset($this->settings['orderByDirection'])
			&& defined($this->settings['orderByDirection'])
		) {
			$orderDirection = constant($this->settings['orderByDirection']);
		}

		return $orderDirection;
	}
}
