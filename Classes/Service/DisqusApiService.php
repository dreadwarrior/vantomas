<?php
namespace Dreadwarrior\Vantomas\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (tommy@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

/**
 * DisqusApiService provides access to the disqus HTTP API
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class DisqusApiService implements SingletonInterface {

	/**
	 * base url of the API service
	 *
	 * @var string
	 */
	protected $baseUrl  = 'https://disqus.com/api/3.0/';

	/**
	 *
	 * @var string
	 */
	protected $apiKey = '';

	/**
	 * sets self::$apiKey and self::$baseUrl
	 *
	 * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$configuration = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_SETTINGS);

		$apiConfiguration = $configuration['disqus'];

		$this->apiKey = $apiConfiguration['apiKey'];

		if ('' !== trim($apiConfiguration['baseUrl'])) {
			$this->baseUrl = $apiConfiguration['baseUrl'];
		}
	}

	public function loadData($url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
	}

	public function getData($url) {
		$response = $this->loadData($url);

		return json_decode($response);
	}

	public function listForumPosts($forumName, $since = NULL, $related = array(), $cursor = NULL, $limit = 25, $query = NULL, $include = array(), $order = 'desc') {
		$params = array();

		$params[] = 'forum=' . $forumName;

		if (is_integer($since)) {
			$params[] = 'since=' . $since;
		}

		if (is_array($related) && 0 < count($related)) {
			foreach ($related as $_ => $relatedItem) {
				$params[] = 'related=' . $relatedItem;
			}
		}

		if (FALSE === is_null($cursor)) {
			$params[] = 'cursor=' . $cursor;
		}

		if (is_numeric($limit)) {
			$params[] = 'limit=' . $limit;
		}

		if (FALSE === is_null($query)) {
			$params[] = 'query=' . $query;
		}

		if (is_array($include) && 0 < count($include)) {
			foreach ($include as $_ => $includeItem) {
				$params[] = 'include=' . $includeItem;
			}
		}

		$params[] = 'order=' . $order;

		try {
			return $this->getData('forums/listPosts.json?api_key=' . $this->apiKey . '&' . implode('&', $params));
		} catch (\Exception $e) {
		}
	}
}
?>