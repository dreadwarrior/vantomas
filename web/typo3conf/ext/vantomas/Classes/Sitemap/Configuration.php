<?php
namespace DreadLabs\Vantomas\Sitemap;

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
use DreadLabs\VantomasWebsite\Sitemap\ConfigurationInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * TypoScript configuration impl
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Configuration implements ConfigurationInterface {

	/**
	 * @var string
	 */
	private static $configurationRoot = 'sitemap';

	/**
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @var array
	 */
	private $settings = array();

	/**
	 * @param ConfigurationManagerInterface $configurationManager
	 * @param ObjectManagerInterface $objectManager
	 * @return self
	 */
	public function __construct(
		ConfigurationManagerInterface $configurationManager,
		ObjectManagerInterface $objectManager
	) {
		$configuration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$this->settings = $configuration[self::$configurationRoot];

		$this->objectManager = $objectManager;
	}
	/**
	 * @return PageIdCollectionInterface
	 */
	public function getParentPageIds() {
		return $this->getPageIdCollectionFromSetting('pids');
	}

	/**
	 * @param $settingKey
	 * @return PageIdCollectionInterface
	 */
	private function getPageIdCollectionFromSetting($settingKey) {
		$pageIdCollection = $this->objectManager->get(PageIdCollectionInterface::class);
		foreach ($this->settings[$settingKey] as $pid) {
			$pageId = $this->objectManager->get(PageId::class, (int) $pid);
			$pageIdCollection->add($pageId);
		}
		return $pageIdCollection;
	}

	/**
	 * @return PageIdCollectionInterface
	 */
	public function getExcludePageIds() {
		return $this->getPageIdCollectionFromSetting('excludeUids');
	}
}