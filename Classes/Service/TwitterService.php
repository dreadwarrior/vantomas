<?php
namespace DreadLabs\Vantomas\Service;

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

/**
 * TwitterService - service to the twitter API
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class TwitterService {

	/**
	 *
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * service specific settings
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 *
	 * @var \Net_Http_Client
	 * @inject
	 */
	protected $client;

	/**
	 *
	 * @var string
	 */
	protected $bearerToken;

	/**
	 * Sets the UA and generates the bearer token
	 *
	 * @return void
	 */
	public function initializeObject() {
		$settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$this->settings = $settings['twitter'];

		$this->client->setHeader('User Agent: van-tomas.de Twitter App v1.0');

		$this->setBearerToken();
	}

	/**
	 * bearer token retrieval
	 *
	 * @return void
	 */
	protected function setBearerToken() {
		$bearerTokenCredentials = base64_encode(sprintf('%s:%s',
			urlencode($this->settings['consumerKey']),
			urlencode($this->settings['consumerSecret'])
		));

		$this->client->setHeader('Content-Type', 'application/x-www-form-urlencoded;charset=UTF-8');
		$this->client->setHeader('Authorization', 'Basic ' . $bearerTokenCredentials);

		$this->client->post($this->settings['bearerTokenUrl'], array('grant_type' => 'client_credentials'));

		$bearerToken = array();

		if ($this->client->getStatus() === 200) {
			$responseBody = $this->client->getResponse()->getBody();
			$bearerToken = json_decode($responseBody);
		} else {
			throw new \Exception('Cannot retrieve bearer: ' . $this->client->getBody());
		}

		if ($bearerToken->token_type === 'bearer') {
			$this->bearerToken = $bearerToken->access_token;
		}
	}

	/**
	 *
	 * @param string $url the endpoint
	 * @param array $parameters additional parameters
	 * @return array
	 */
	public function get($url, $parameters = array()) {
		$this->client->setHeader('Authorization', 'Bearer ' . $this->bearerToken);

		$requestUrl = $url;

		if (is_array($parameters) && count($parameters) > 0) {
			$requestUrl .= '?' . http_build_query($parameters);
		}

		$this->client->get($requestUrl);

		if ($this->client->getStatus() !== 200) {
			throw new \Exception('Communication error: ' . $this->client->getBody());
		}

		return json_decode($this->client->getBody());
	}
}
?>