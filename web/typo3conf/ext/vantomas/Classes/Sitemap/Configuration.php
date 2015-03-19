<?php
namespace DreadLabs\Vantomas\Sitemap;

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

use DreadLabs\VantomasWebsite\Page\PageIdCollectionInterface;
use DreadLabs\VantomasWebsite\Sitemap\ConfigurationInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

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
		$pageIdCollection = $this->objectManager->get('DreadLabs\\VantomasWebsite\\Page\\PageIdCollectionInterface');
		foreach ($this->settings[$settingKey] as $pid) {
			$pageId = $this->objectManager->get('DreadLabs\\VantomasWebsite\\Page\\PageId', (int) $pid);
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