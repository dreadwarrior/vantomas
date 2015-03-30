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

use DreadLabs\VantomasWebsite\ContactForm;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Error;
use TYPO3\CMS\Extbase\Validation\Exception;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validates the incoming contact form for spam prevention
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ContactFormAntiSpamValidator extends AbstractValidator {

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

			$isValid = TRUE;
		} catch (Exception $e) {
			$error = new Error(
				$e->getMessage(),
				$e->getCode()
			);
			$this->result->addError($error);

			$isValid = FALSE;
		}

		return $isValid;
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
		$refererHost = parse_url($referer, PHP_URL_HOST);
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
		$honeyPot = $contactForm->getPerson()->getCity();
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

		if (is_null($then)) {
			throw new Exception(self::ERROR_MESSAGE, 1426330922);
		}

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

		$message = $contactForm->getMessage()->getMessage();

		$hasUrlMatches = FALSE !== preg_match_all(
			self::URL_PATTERN,
			$message,
			$urlMatches,
			PREG_SET_ORDER
		);
		$urlMatchCountTooHigh = count($urlMatches) >= self::MAX_URLS;

		if ($hasUrlMatches && $urlMatchCountTooHigh) {
			throw new Exception(
				self::ERROR_MESSAGE,
				1400453056
			);
		}
	}
}