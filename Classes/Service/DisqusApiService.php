<?php
class Tx_Vantomas_Service_DisqusApiService implements t3lib_Singleton {

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

	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$configuration = $configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManager::CONFIGURATION_TYPE_SETTINGS);

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
		} catch (Exception $e) {
		}
	}
}
?>