<?php
namespace DreadLabs\Vantomas\Service;

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

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * TwitterService - service to the twitter API
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TwitterService {

	/**
	 * the content type for retrieving the bearer token
	 *
	 * @var string
	 */
	const BEARER_TOKEN_CONTENT_TYPE = 'application/x-www-form-urlencoded;charset=UTF-8';

	/**
	 *
	 * @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
	 */
	protected $cacheInstance;

	/**
	 *
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 *
	 * @var \Net_Http_Client
	 */
	protected $client;

	/**
	 * service specific settings
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 *
	 * @var string
	 */
	protected $bearerToken = '';

	/**
	 * Injects the cache manager
	 *
	 * @param CacheManager $cacheManager
	 * @return void
	 */
	public function injectCacheManager(CacheManager $cacheManager) {
		$this->cacheInstance = $cacheManager->getCache('cache_hash');
	}

	/**
	 * Injects the configuration manager
	 *
	 * @param ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager) {
		$settings = $configurationManager->getConfiguration(
			\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
		);
		$this->settings = $settings['twitter'];
	}

	/**
	 * Injects the http client
	 *
	 * @param \Net_Http_Client $httpClient
	 * @return void
	 */
	public function injectHttpClient(\Net_Http_Client $httpClient) {
		$this->client = $httpClient;
	}

	/**
	 * Initializes the HTTP client + cache instance for bearer token retrieval
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->client->setUserAgent($this->settings['userAgent']);
	}

	/**
	 * Gets data from the given $url api endpoint
	 *
	 * @param string $url the endpoint
	 * @param array $parameters additional parameters
	 * @return array
	 */
	public function get($url, $parameters = array()) {
		$this->client->setHeader('Authorization', 'Bearer ' . $this->getBearerToken());

		if (is_array($parameters) && count($parameters) > 0) {
			$url .= '?' . http_build_query($parameters);
		}

		$this->client->get($url);

		if ($this->client->getStatus() !== 200) {
			throw new \Exception('Communication error: ' . $this->client->getBody());
		}

		return json_decode($this->client->getBody());
	}

	/**
	 * Bearer token retrieval
	 *
	 * First the cache is checked if a bearer token exists. If no cached
	 * bearer token was found, the request is made to the remote bearer token
	 * retrieval endpoint.
	 *
	 * @return string
	 */
	protected function getBearerToken() {
		if ('' !== $this->bearerToken) {
			return $this->bearerToken;
		}

		$bearerTokenCredentials = $this->getBearerTokenCredentials();

		$cacheIdentifier = md5($bearerTokenCredentials);

		if ($this->cacheInstance->has($cacheIdentifier)) {
			$this->bearerToken = $this->cacheInstance->get($cacheIdentifier);
		} else {
			$this->bearerToken = $this->getBearerTokenFromRemote($bearerTokenCredentials);

			$this->cacheInstance->set(
				$cacheIdentifier,
				$this->bearerToken,
				array('ident_twitter_bearer'),
				$this->settings['bearerCacheLifetime']
			);
		}

		return $this->bearerToken;
	}

	/**
	 * Returns the bearer token credentials in the expected format
	 *
	 * @see https://dev.twitter.com/docs/auth/application-only-auth
	 * @return string
	 */
	protected function getBearerTokenCredentials() {
		$bearerTokenCredentials = base64_encode(sprintf('%s:%s',
			urlencode($this->settings['consumerKey']),
			urlencode($this->settings['consumerSecret'])
		));

		return $bearerTokenCredentials;
	}

	/**
	 * Fetches a bearer token from the bearer token retrieval endpoint
	 *
	 * @throws \Exception If response status != 200 or token_type != 'bearer'
	 * @return string
	 */
	protected function getBearerTokenFromRemote($bearerTokenCredentials) {
		$this->client->setHeader('Content-Type', self::BEARER_TOKEN_CONTENT_TYPE);
		$this->client->setHeader('Authorization', 'Basic ' . $bearerTokenCredentials);

		$this->client->post(
			$this->settings['bearerTokenUrl'],
			array('grant_type' => 'client_credentials')
		);

		$bearerToken = array();

		if ($this->client->getStatus() !== 200) {
			throw new \Exception('Cannot retrieve bearer: ' . $this->client->getBody());
		}

		$responseBody = $this->client->getResponse()->getBody();
		$bearerToken = json_decode($responseBody);

		if ($bearerToken->token_type !== 'bearer') {
			throw new \Exception('Cannot retrieve bearer, actual token type (' . $bearerToken->token_type . ') does not match expected "bearer".');
		}

		return $bearerToken->access_token;
	}
}