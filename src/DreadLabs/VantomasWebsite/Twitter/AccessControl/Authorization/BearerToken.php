<?php
namespace DreadLabs\VantomasWebsite\Twitter\AccessControl\Authorization;

use DreadLabs\VantomasWebsite\Twitter\AccessControl\AuthenticationInterface;
use DreadLabs\VantomasWebsite\Twitter\AccessControl\AuthorizationInterface;
use DreadLabs\VantomasWebsite\Twitter\AccessControl\Exception\AuthorizationFailedException;
use DreadLabs\VantomasWebsite\Twitter\AccessControl\Exception\InvalidBearerTokenTypeException;
use DreadLabs\VantomasWebsite\Twitter\CacheInterface;
use DreadLabs\VantomasWebsite\Twitter\ConfigurationInterface;
use DreadLabs\Net\Http\ClientInterface;

class BearerToken implements AuthorizationInterface {

	/**
	 * Content type for retrieving the bearer token
	 *
	 * @var string
	 */
	const BEARER_TOKEN_CONTENT_TYPE = 'application/x-www-form-urlencoded;charset=UTF-8';

	/**
	 * @var ClientInterface
	 */
	private $client;

	/**
	 * @var ConfigurationInterface
	 */
	private $configuration;

	/**
	 * @var CacheInterface
	 */
	private $cache;

	/**
	 * @var string
	 */
	private $credentials;

	/**
	 * @var \stdClass
	 */
	private $token;

	/**
	 * @param ClientInterface $client
	 * @param ConfigurationInterface $configuration
	 * @param CacheInterface $cache
	 */
	public function __construct(
		ClientInterface $client,
		ConfigurationInterface $configuration,
		CacheInterface $cache
	) {
		$this->client = $client;
		$this->configuration = $configuration;
		$this->cache = $cache;

		$this->initializeCredentials();
	}

	/**
	 * Initializes the bearer token credentials in the expected format
	 *
	 * @see https://dev.twitter.com/docs/auth/application-only-auth
	 * @return void
	 */
	private function initializeCredentials() {
		$this->credentials = base64_encode(sprintf('%s:%s',
			urlencode($this->configuration->getConsumerKey()),
			urlencode($this->configuration->getConsumerSecret())
		));
	}

	/**
	 * @param AuthenticationInterface $authentication
	 * @return void
	 * @throws AuthorizationFailedException
	 * @throws InvalidBearerTokenTypeException
	 */
	public function authorize(AuthenticationInterface $authentication) {
		$this->setHeader();

		$this->fetchToken();

		$this->checkTokenType();

		$authentication->addAttribute($this->token->access_token);
	}

	private function setHeader() {
		$this->client->setUserAgent($this->configuration->getUserAgent());
		$this->client->setHeader('Content-Type', self::BEARER_TOKEN_CONTENT_TYPE);
		$this->client->setHeader('Authorization', 'Basic ' . $this->credentials);
	}

	private function fetchToken() {
		$cacheIdentifier = md5($this->credentials);

		if (!$this->cache->has($cacheIdentifier)) {
			$this->fetchTokenFromRemote();

			$this->cache->set(
				$cacheIdentifier,
				json_encode($this->token),
				array('ident_twitter_bearer'),
				$this->configuration->getBearerCacheLifetime()
			);
		}

		$this->token = json_decode($this->cache->get($cacheIdentifier));
	}

	private function fetchTokenFromRemote() {
		$this->client->post(
			$this->configuration->getBearerTokenUrl(),
			array('grant_type' => 'client_credentials')
		);

		if ($this->client->getStatus() !== 200) {
			throw new AuthorizationFailedException('Cannot retrieve bearer: ' . $this->client->getBody());
		}

		$responseBody = $this->client->getResponse()->getBody();
		$this->token = json_decode($responseBody);
	}

	private function checkTokenType() {
		if ($this->token->token_type !== 'bearer') {
			throw new InvalidBearerTokenTypeException(
				'Token type (' . $this->token->token_type . ') does not match expected "bearer".'
			);
		}
	}
}