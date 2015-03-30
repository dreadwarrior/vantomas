<?php
namespace DreadLabs\Vantomas\RssFeed;

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

use DreadLabs\VantomasWebsite\Page\PageId;
use DreadLabs\VantomasWebsite\Page\PageIdCollectionInterface;
use DreadLabs\VantomasWebsite\Page\PageType;
use DreadLabs\VantomasWebsite\Page\PageTypeCollectionInterface;
use DreadLabs\VantomasWebsite\RssFeed\ConfigurationInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
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
	 * @var PageIdCollectionInterface
	 */
	private $pageIds;

	/**
	 * @var PageTypeCollectionInterface
	 */
	private $pageTypes;

	/**
	 * @param ConfigurationManagerInterface $configurationManager
	 * @param PageIdCollectionInterface $pageIds
	 * @param PageTypeCollectionInterface $pageTypes
	 */
	public function __construct(
		ConfigurationManagerInterface $configurationManager,
		PageIdCollectionInterface $pageIds,
		PageTypeCollectionInterface $pageTypes
	) {
		$this->configurationManager = $configurationManager;
		$this->contentObject = $this->configurationManager->getContentObject();
		$configuration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$this->settings = $configuration[self::$configurationRoot];

		$this->pageIds = $pageIds;
		$this->pageTypes = $pageTypes;

		$this->initializePageIds();
	}

	private function initializePageIds() {
		$startPid = 0;
		$recursiveLevels = 1;

		if (isset($this->settings['startPid'])) {
			$startPid = (int) $this->settings['startPid'];
		}

		if (isset($this->settings['recursiveLevels'])) {
			$recursiveLevels = MathUtility::forceIntegerInRange($this->settings['recursiveLevels'], 0, 999);
		}

		if ($startPid > 0) {
			$pageIds = $this->contentObject->getTreeList(
				$startPid,
				$recursiveLevels
			);

			$pageIds = GeneralUtility::trimExplode(',', $pageIds);

			foreach ($pageIds as $pageId) {
				$this->pageIds->add(new PageId($pageId));
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPageIds() {
		return $this->pageIds;
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
	public function getOrdering() {
		$orderBy = 'lastUpdated';
		$orderByDirection = QueryInterface::ORDER_DESCENDING;

		if (
			isset($this->settings['orderBy'])
			&& GeneralUtility::inList(self::$allowedOrderByFields, $this->settings['orderBy'])
		) {
			$orderBy = (string) $this->settings['orderBy'];
		}

		if (
			isset($this->settings['orderByDirection'])
			&& defined($this->settings['orderByDirection'])
		) {
			$orderByDirection = constant($this->settings['orderByDirection']);
		}

		return array(
			$orderBy => $orderByDirection
		);
	}
}