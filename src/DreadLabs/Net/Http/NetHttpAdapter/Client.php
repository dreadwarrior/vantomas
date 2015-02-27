<?php
namespace DreadLabs\Net\Http\NetHttpAdapter;

use DreadLabs\Net\Http\ClientInterface;
use DreadLabs\Net\Http\ResponseInterface;

/**
 * Adapter to \Net_Http_Client
 */
class Client implements ClientInterface {

	/**
	 * @var \Net_Http_Client
	 */
	private $client;

	/**
	 * @param \Net_Http_Client $client
	 */
	public function __construct(\Net_Http_Client $client) {
		$this->client = $client;
	}

	/**
	 * @param string $userAgent
	 * @return void
	 */
	public function setUserAgent($userAgent) {
		$this->client->setUserAgent($userAgent);
	}

	/**
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function setHeader($key, $value) {
		$this->client->setHeader($key, $value);
	}

	/**
	 * @param string $url
	 * @return void
	 */
	public function get($url) {
		$this->client->get($url);
	}

	/**
	 * @param string $uri
	 * @param mixed $query
	 * @return void
	 */
	public function post($uri, $query) {
		$this->client->post($uri, $query);
	}

	/**
	 * @return int
	 */
	public function getStatus() {
		return $this->client->getStatus();
	}

	/**
	 * @return string
	 */
	public function getBody() {
		return $this->client->getBody();
	}

	/**
	 * @return ResponseInterface
	 */
	public function getResponse() {
		return new Response($this->client->getStatus(), $this->client->getHeaders(), $this->client->getBody());
	}
}