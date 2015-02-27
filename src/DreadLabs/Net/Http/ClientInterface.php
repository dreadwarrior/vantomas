<?php
namespace DreadLabs\Net\Http;

/**
 * Simple HTTP client interface.
 */
interface ClientInterface {

	/**
	 * @param string $userAgent
	 * @return void
	 */
	public function setUserAgent($userAgent);

	/**
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function setHeader($key, $value);

	/**
	 * @param string $url
	 * @return void
	 */
	public function get($url);

	/**
	 * @param string $uri
	 * @param mixed $query
	 * @return void
	 */
	public function post($uri, $query);

	/**
	 * @return int
	 */
	public function getStatus();

	/**
	 * @return string
	 */
	public function getBody();

	/**
	 * @return ResponseInterface
	 */
	public function getResponse();
}