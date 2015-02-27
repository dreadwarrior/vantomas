<?php
namespace DreadLabs\Vantomas\Domain\Validator;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Thomas Juhnke <typo3@van-tomas.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\Vantomas\Domain\Model\ContactForm;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Error;
use TYPO3\CMS\Extbase\Validation\Exception;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validates the incoming contact form
 *
 * @package \DreadLabs\Vantomas\Domain\Validator
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class ContactFormValidator extends AbstractValidator {

	/**
	 * Minimum amount of seconds for form submission
	 *
	 * @var integer
	 */
	const MIN_TIMESTAMP_DELTA = 10;

	/**
	 * Maximum amount of seconds for form submission
	 *
	 * @var integer
	 */
	const MAX_TIMESTAMP_DELTA = 300;

	/**
	 * Maximum amount of URLs in contact form message field
	 *
	 * @var integer
	 */
	const MAX_URLS = 3;

	/**
	 *
	 * @var string
	 */
	const URL_PATTERN = '/http:\/\//ims';

	/**
	 *
	 * @var string
	 */
	const ERROR_MESSAGE = 'Invalid form submission.';

	/**
	 * Validates the incoming contact form
	 *
	 * @param mixed $contactForm
	 * @see \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator::isValid()
	 * @return bool|void
	 */
	public function isValid($contactForm) {
		try {
			$this->isValidUserAgent();
			$this->isValidReferer();
			$this->isValidHoneyPot($contactForm);
			$this->isValidCreationDateDelta($contactForm);
			$this->isValidUrlThreshold($contactForm);

			return TRUE;
		} catch (Exception $e) {
			$error = new Error(
				$e->getMessage(),
				$e->getCode()
			);
			$this->result->addError($error);

			return FALSE;
		}
	}

	/**
	 * User Agent check
	 *
	 * @return void
	 * @throws Exception
	 */
	protected function isValidUserAgent() {
		$userAgent = GeneralUtility::getIndpEnv('HTTP_USER_AGENT');
		if (empty($userAgent)) {
			throw new Exception(
				self::ERROR_MESSAGE,
				1400451338
			);
		}
	}

	/**
	 * Referrer check
	 *
	 * @return void
	 * @throws Exception
	 */
	protected function isValidReferer() {

		$referer = GeneralUtility::getIndpEnv('HTTP_REFERER');
		$host = GeneralUtility::getIndpEnv('HTTP_HOST');
		$refererHost = parse_url($referer,  PHP_URL_HOST);
		$httpHost = parse_url($host, PHP_URL_HOST);

		if (!is_null($httpHost) && $refererHost !== $httpHost) {
			throw new Exception(
				self::ERROR_MESSAGE,
				1400451586
			);
		}

		if (is_null($httpHost) && $refererHost !== $host) {
			throw new Exception(
				self::ERROR_MESSAGE,
				1416434536
			);
		}
	}

	/**
	 * honey pot check
	 *
	 * @param ContactForm $contactForm
	 * @return void
	 * @throws Exception
	 */
	protected function isValidHoneyPot(ContactForm $contactForm) {
		$honeyPot = $contactForm->getCity();
		if (!empty($honeyPot)) {
			throw new Exception(
				self::ERROR_MESSAGE,
				1400452039
			);
		}
	}

	/**
	 * timestamp check
	 *
	 * @param ContactForm $contactForm
	 * @return void
	 * @throws Exception
	 */
	protected function isValidCreationDateDelta(ContactForm $contactForm) {
		$now = new \DateTime();
		$then = $contactForm->getCreationDate();
		$creationDateDelta = $now->format('U') - $then->format('U');

		if ($creationDateDelta < self::MIN_TIMESTAMP_DELTA) {
			throw new Exception(
				self::ERROR_MESSAGE,
				1400452475
			);
		}

		if ($creationDateDelta > self::MAX_TIMESTAMP_DELTA) {
			throw new Exception(
				self::ERROR_MESSAGE,
				1400452604
			);
		}
	}

	/**
	 * url-in-message check
	 *
	 * @param ContactForm $contactForm
	 * @return void
	 * @throws Exception
	 */
	protected function isValidUrlThreshold(ContactForm $contactForm) {
		$urlMatches = array();

		$message = $contactForm->getMessage();

		$hasUrlMatches = FALSE !== preg_match_all(
			self::URL_PATTERN,
			$message,
			$urlMatches,
			PREG_SET_ORDER
		);
		$urlMatchCountThresholdExceeded = count($urlMatches) >= self::MAX_URLS;

		if ($hasUrlMatches && $urlMatchCountThresholdExceeded) {
			throw new Exception(
				self::ERROR_MESSAGE,
				1400453056
			);
		}
	}
}