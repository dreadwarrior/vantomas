<?php
namespace DreadLabs\Vantomas\Service\Disqus;

use \TYPO3\CMS\Core\SingletonInterface;

abstract class AbstractApi implements SingletonInterface {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

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
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	public function setBaseUrl($baseUrl) {
		if ('' !== trim($baseUrl)) {
			$this->baseUrl = $baseUrl;
		}
	}

	public function setApiKey($apiKey) {
		$this->apiKey = $apiKey;
	}

	public function setUrl($url) {
		$this->url = $this->replaceApiKey($url);
	}

	protected function replaceApiKey($url) {
		$replacePairs = array(
			'%apiKey%' => $this->apiKey,
		);

		return strtr($url, $replacePairs);
	}

	abstract public function loadData();

	abstract protected function createClient();

	abstract protected function sendRequest();

	abstract protected function destroyClient();
}
?>