<?php
namespace DreadLabs\VantomasWebsite;

use DreadLabs\VantomasWebsite\Twitter\AccessControl\AuthenticationInterface;
use DreadLabs\VantomasWebsite\Twitter\AccessControl\AuthorizationInterface;
use DreadLabs\VantomasWebsite\Twitter\ConfigurationInterface;
use DreadLabs\Net\Http\ClientInterface;

/**
 * Simple Twitter API service.
 */
class Twitter implements TwitterInterface {

	/**
	 * @var AuthenticationInterface
	 */
	private $authentication;

	/**
	 * @var AuthorizationInterface
	 */
	private $authorization;

	/**
	 * @var ConfigurationInterface
	 */
	private $configuration;

	/**
	 *
	 * @var ClientInterface
	 */
	private $client;

	/**
	 * @var array
	 */
	private $parameters = array();

	/**
	 *
	 * @param AuthenticationInterface $authentication
	 * @param AuthorizationInterface $authorization
	 * @param ConfigurationInterface $configuration
	 * @param ClientInterface $httpClient
	 */
	public function __construct(
		AuthenticationInterface $authentication,
		AuthorizationInterface $authorization,
		ConfigurationInterface $configuration,
		ClientInterface $httpClient
	) {
		$this->authentication = $authentication;
		$this->authorization = $authorization;
		$this->configuration = $configuration;
		$this->client = $httpClient;
	}

	/**
	 * @param string $key
	 * @param string|int $value
	 * @return void
	 */
	public function addParameter($key, $value) {
		$this->parameters[$key] = $value;
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public function getTimeline() {
		return $this->get(
			'https://api.twitter.com/1.1/statuses/user_timeline.json',
			$this->parameters
		);
	}

	public function getSearchResult() {
		return $this->get(
			'https://api.twitter.com/1.1/search/tweets.json',
			$this->parameters
		);
	}

	/**
	 * Gets data from the given $url api endpoint
	 *
	 * @param string $url the endpoint
	 * @param array $parameters additional parameters
	 * @return array
	 * @throws \Exception
	 */
	private function get($url, array $parameters = array()) {
		if (!$this->authentication->isAuthenticated()) {
			$this->authorization->authorize($this->authentication);
		}

		$this->client->setUserAgent($this->configuration->getUserAgent());
		$this->client->setHeader('Authorization', 'Bearer ' . $this->authentication->toString());
		$this->client->get($this->buildUrl($url, $parameters));

		if ($this->client->getStatus() !== 200) {
			throw new \Exception('Communication error: ' . $this->client->getBody());
		}

		return json_decode($this->client->getBody());
	}

	/**
	 *
	 * @param string $url
	 * @param array $parameters
	 * @return string
	 */
	private function buildUrl($url, array $parameters = array()) {
		if (is_array($parameters) && count($parameters) > 0) {
			$url .= '?' . http_build_query($parameters);
		}

		return $url;
	}
}