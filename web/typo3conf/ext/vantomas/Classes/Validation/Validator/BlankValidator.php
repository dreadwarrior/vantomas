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
 * Validates if the incoming value is blank
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class BlankValidator extends AbstractValidator {

	/**
	 * List of supported options for this validator
	 *
	 * @var array
	 */
	protected $supportedOptions = array(
		'propertyPath' => array('', 'Property path if incoming value is an object.', 'string'),
	);

	/**
	 * Check if $value is valid. If it is not valid, needs to add an error
	 * to result.
	 *
	 * @param mixed $value Incoming value to validate
	 *
	 * @return void
	 */
	protected function isValid($value) {
		if (!empty($value)) {
			$error = new Error(
				'The given property must be left blank.',
				1400452039
			);
			$this->result->addError($error);
		}
	}
}
