<?php
namespace DreadLabs\Vantomas\Service\Disqus;

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

use \TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

/**
 * Provides access to the disqus HTTP API
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Api implements ApiInterface {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * 
	 * @var array
	 */
	protected $apiConfiguration;

	/**
	 *
	 * @var string
	 */
	protected $client = 'curl';

	/**
	 * @var \DreadLabs\Vantomas\Service\Disqus\AbstractApi
	 */
	protected $concreteApi = NULL;

	/**
	 *
	 * @var \DreadLabs\Vantomas\Service\Disqus\Method\MethodInterface
	 */
	protected $apiMethod = NULL;

	/**
	 * Sets and checks API configuration
	 * 
	 * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$configuration = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_SETTINGS);

		$this->apiConfiguration = $configuration['disqus'];

		if ('' !== trim($this->apiConfiguration['client'])) {
			$this->client = $this->apiConfiguration['client'];
		}
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
		$this->initializeConcreteApi();
	}

	/**
	 * @return void
	 */
	protected function initializeConcreteApi() {
		$concreteApi = 'DreadLabs\\Vantomas\\Service\\Disqus\\' . ucfirst($this->client) . 'Api';
		$this->concreteApi = $this->objectManager->get($concreteApi);

		$this->concreteApi->setBaseUrl($this->apiConfiguration['baseUrl']);
	}

	/**
	 *
	 * @param $methodSignature string
	 * @return \DreadLabs\Vantomas\Service\Disqus\ApiInterface
	 */
	public function execute($methodSignature) {
		$this->apiMethod = $this->objectManager->get('DreadLabs\\Vantomas\\Service\\Disqus\\Method\\MethodInterface', $methodSignature);

		return $this;
	}

	public function with(array $parameters) {
		$methodUrl = $this->apiMethod->getUrl($parameters);

		$this->concreteApi->setUrl($methodUrl);

		return $this->getData();
	}

	protected function getData() {
		$response = $this->concreteApi->getData();

		$data = $this->decodeData($response);

		if (0 !== (integer) $data->code) {
			$data = array(
				'error' => $data->response,
			);
		}

		return $data;
	}

	protected function decodeData($data) {
		$decoder = $this->objectManager->get('DreadLabs\\Vantomas\\Service\\Disqus\\Decoder\\DecoderInterface', $this->apiMethod);

		return $decoder->decode($data);
	}
}
?>