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
 * Validates if URLs are below the given limit
 */
class UrlThresholdValidator extends AbstractValidator {

	/**
	 * @var array
	 */
	protected $supportedOptions = array(
		'max' => array(3, 'Amount of maximum URLs', 'integer'),
		'pattern' => array('/http:\/\//ims', 'Pattern to match incoming value against.', 'string'),
	);

	/**
	 * Check if $value is valid. If it is not valid, needs to add an error
	 * to result.
	 *
	 * @param mixed $value
	 * @return void
	 */
	protected function isValid($value) {
		$urlMatches = array();

		$hasUrlMatches = FALSE !== preg_match_all(
				$this->options['pattern'],
				$value,
				$urlMatches,
				PREG_SET_ORDER
			);
		$urlMatchCountTooHigh = count($urlMatches) >= $this->options['max'];

		if ($hasUrlMatches && $urlMatchCountTooHigh) {
			$error = new Error(
				sprintf('The URL threshold was exceeded the value of %s within %s', $this->options['max'], $value),
				1400453056
			);
			$this->result->addError($error);
		}
	}
}