<?php
namespace DreadLabs\Vantomas\Authentication;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Http\HttpRequest;

/**
 * ReCaptcha
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ReCaptcha implements ControlInterface {

	/**
	 * The ReCaptcha server integration secret
	 *
	 * @var string
	 */
	private $secret;

	/**
	 * The captcha response of the form request
	 *
	 * @var NULL|string
	 */
	private $captchaResponse;

	/**
	 * A HTTP Client
	 *
	 * @var HttpRequest
	 */
	private $client;

	/**
	 * Constructor
	 *
	 * @param string $secret The ReCaptcha server integration secret
	 * @param string|NULL $captchaResponse The captcha response of the form request
	 * @param HttpRequest $client A HTTP Client
	 */
	public function __construct($secret, $captchaResponse, HttpRequest $client) {
		$this->secret = (string) $secret;
		$this->captchaResponse = $captchaResponse;
		$this->client = $client;

		$this->initializeClient();
	}

	/**
	 * Initializes the HTTP Client
	 *
	 * @return void
	 * @throws \HTTP_Request2_LogicException If the request method is not supported
	 */
	private function initializeClient() {
		$this->client->setMethod(HttpRequest::METHOD_POST);
		$this->client->setUrl('https://www.google.com/recaptcha/api/siteverify');
		$this->client->addPostParameter('secret', $this->secret);
	}

	/**
	 * Flags if the used Control impl detected a threat
	 *
	 * @return bool
	 */
	public function isThreat() {
		if (is_null($this->captchaResponse) || empty($this->captchaResponse)) {
			return TRUE;
		}

		$this->client->addPostParameter('response', $this->captchaResponse);

		$apiResponse = $this->client->send();

		if ($apiResponse->getStatus() !== 200) {
			return TRUE;
		}

		$validationResponse = json_decode($apiResponse->getBody());

		if (is_null($validationResponse) || !$validationResponse->success) {
			return TRUE;
		}

		return FALSE;
	}
}
