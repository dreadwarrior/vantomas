<?php
namespace DreadLabs\Net\Http\NetHttpAdapter;

use DreadLabs\Net\Http\ResponseInterface;

/**
 * Adapter to \Net_Http_Response
 */
class Response implements ResponseInterface {

	/**
	 * @var \Net_Http_Response
	 */
	private $response;

	/**
	 * @param $status
	 * @param $headers
	 * @param string $body
	 */
	public function __construct($status, $headers, $body = '') {
		$this->response = new \Net_Http_Response($status, $headers, $body);
	}

	/**
	 * @return string
	 */
	public function getBody() {
		return $this->response->getBody();
	}
}