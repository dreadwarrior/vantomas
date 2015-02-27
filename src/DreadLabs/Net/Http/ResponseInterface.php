<?php
namespace DreadLabs\Net\Http;

/**
 * Simple HTTP response interface
 */
interface ResponseInterface {

	/**
	 * @return string
	 */
	public function getBody();
}