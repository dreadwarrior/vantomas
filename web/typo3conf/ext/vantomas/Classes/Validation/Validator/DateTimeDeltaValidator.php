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

use TYPO3\CMS\Extbase\Validation\Error;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Allows validation of a DateTime delta
 */
class DateTimeDeltaValidator extends AbstractValidator {

	/**
	 * @var array
	 */
	protected $supportedOptions = array(
		'min' => array(10, 'Minimum delta in seconds', 'integer'),
		'max' => array(300, 'Maximum delta in seconds', 'integer'),
	);

	/**
	 * Check if $value is valid. If it is not valid, needs to add an error
	 * to result.
	 *
	 * @param mixed $value
	 * @return void
	 */
	protected function isValid($value) {
		$now = new \DateTime();
		$then = $value instanceof \DateTime ? $value : new \DateTime('@' . (int) $value);

		$delta = $now->format('U') - $then->format('U');

		if ($this->isTooLow($delta)) {
			$error = new Error(
				'The date of the incoming value falls short of the minimum timestamp delta.',
				1400452475
			);
			$this->result->addError($error);
		}

		if ($this->isTooHigh($delta)) {
			$error = new Error(
				'The date of the incoming value excesses the maximum timestamp delta.',
				1400452604
			);
			$this->result->addError($error);
		}
	}

	/**
	 * @param int $delta
	 * @return bool
	 */
	private function isTooLow($delta) {
		return $delta < (int) $this->options['min'];
	}

	/**
	 * @param int $delta
	 * @return bool
	 */
	private function isTooHigh($delta) {
		return $delta > (int) $this->options['max'];
	}
}