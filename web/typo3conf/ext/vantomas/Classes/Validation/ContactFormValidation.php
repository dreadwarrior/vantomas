<?php
namespace DreadLabs\Vantomas\Validation;

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Thomas Juhnke <typo3@van-tomas.de>
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

use TYPO3\CMS\Extbase\Validation\Validator\ConjunctionValidator;
use TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator;
use TYPO3\CMS\Extbase\Validation\Validator\GenericObjectValidator;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;
use TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface;
use TYPO3\CMS\Extbase\Validation\ValidatorResolver;

/**
 * Encapsulates a validation suite for the contact form
 *
 * @package DreadLabs\Vantomas\Validation
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class ContactFormValidation {

	/**
	 * @var ValidatorResolver
	 */
	private $validatorResolver;

	/**
	 * @var GenericObjectValidator
	 */
	private $validator;

	public function __construct(
		ValidatorResolver $validatorResolver,
		GenericObjectValidator $validator
	) {
		$this->validatorResolver = $validatorResolver;
		$this->validator = $validator;
	}

	/**
	 * @param ConjunctionValidator $argumentValidator
	 * @return void
	 */
	public function addTo(ConjunctionValidator $argumentValidator) {
		$this->validator->addPropertyValidator('person', $this->getPersonValidator());
		$this->validator->addPropertyValidator('message', $this->getMessageValidator());
		$this->validator->addPropertyValidator('creationDate', $this->getNotEmptyValidator());

		$argumentValidator->addValidator($this->validator);
	}

	/**
	 * @return ValidatorInterface
	 */
	private function getPersonValidator() {
		$validator = $this->getGenericObjectValidator();
		$validator->addPropertyValidator('firstName', $this->getNotEmptyValidator());
		$validator->addPropertyValidator('email', $this->getEmailAddressValidator());

		return $validator;
	}

	/**
	 * @return ValidatorInterface
	 */
	private function getMessageValidator() {
		$validator = $this->getGenericObjectValidator();
		$validator->addPropertyValidator('subject', $this->getNotEmptyValidator());
		$validator->addPropertyValidator('message', $this->getNotEmptyValidator());

		return $validator;
	}

	/**
	 * @return GenericObjectValidator
	 */
	private function getGenericObjectValidator() {
		return $this->getValidatorFromResolver('GenericObject');
	}

	/**
	 * @return NotEmptyValidator
	 */
	private function getNotEmptyValidator() {
		return $this->getValidatorFromResolver('NotEmpty');
	}

	/**
	 * @return EmailAddressValidator
	 */
	private function getEmailAddressValidator() {
		return $this->getValidatorFromResolver('EmailAddress');
	}

	/**
	 * See ValidatorResolver::createValidator() for more information
	 *
	 * @param string $type
	 * @param array $options
	 * @return ValidatorInterface
	 */
	private function getValidatorFromResolver($type, array $options = array()) {
		return $this->validatorResolver->createValidator($type, $options);
	}
}