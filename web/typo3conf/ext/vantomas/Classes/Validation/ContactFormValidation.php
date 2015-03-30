<?php
namespace DreadLabs\Vantomas\Validation;

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

use TYPO3\CMS\Extbase\Validation\Validator\ConjunctionValidator;
use TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator;
use TYPO3\CMS\Extbase\Validation\Validator\GenericObjectValidator;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;
use TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface;
use TYPO3\CMS\Extbase\Validation\ValidatorResolver;

/**
 * Encapsulates a validation suite for the contact form
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
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

	/**
	 * @param ValidatorResolver $validatorResolver
	 * @param GenericObjectValidator $validator
	 * @return self
	 */
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