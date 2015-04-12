<?php
namespace DreadLabs\Vantomas\Validation\Validator;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Error;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validates if the incoming HTTP referer matches the current host
 */
class RefererHostEqualityValidator extends AbstractValidator {

	/**
	 * @var string
	 */
	private $refererHost;

	/**
	 * @var string
	 */
	private $rawServerHost;

	/**
	 * @var string
	 */
	private $serverHost;

	/**
	 * Check if $value is valid. If it is not valid, needs to add an error
	 * to result.
	 *
	 * @param mixed $value
	 * @return void
	 */
	protected function isValid($value) {
		$this->parseRefererHost();
		$this->parseServerHost();

		$value = $this->refererHostNotEqualsParsedServerHost() || $this->refererHostNotEqualsRawServerHost();

		if ($value) {
			$error = new Error(
				'The HTTP referer does not match the current host.',
				1400451586
			);
			$this->result->addError($error);
		}
	}

	/**
	 * @return void
	 */
	private function parseRefererHost() {
		$referer = GeneralUtility::getIndpEnv('HTTP_REFERER');
		$this->refererHost = parse_url($referer, PHP_URL_HOST);
	}

	/**
	 * @return void
	 */
	private function parseServerHost() {
		$this->rawServerHost = GeneralUtility::getIndpEnv('HTTP_HOST');
		$this->serverHost = parse_url($this->rawServerHost, PHP_URL_HOST);
	}

	/**
	 * @return bool
	 */
	private function refererHostNotEqualsParsedServerHost() {
		$first = !is_null($this->serverHost) && $this->refererHost !== $this->serverHost;
		return $first;
	}

	/**
	 * @return bool
	 */
	private function refererHostNotEqualsRawServerHost() {
		$second = is_null($this->serverHost) && $this->refererHost !== $this->rawServerHost;
		return $second;
	}
}