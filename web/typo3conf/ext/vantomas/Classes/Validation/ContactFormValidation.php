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

use DreadLabs\Vantomas\Validation\Validator\BlankValidator;
use DreadLabs\Vantomas\Validation\Validator\DateTimeDeltaValidator;
use DreadLabs\Vantomas\Validation\Validator\UrlThresholdValidator;
use DreadLabs\VantomasWebsite\Form\Contact\AbstractValidation;
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
class ContactFormValidation extends AbstractValidation {

	/**
	 * Application ValidatorResolver
	 *
	 * @var ValidatorResolver
	 */
	private $validatorResolver;

	/**
	 * GenericObjectValidator
	 *
	 * @var GenericObjectValidator
	 */
	private $validator;

	/**
	 * Constructor
	 *
	 * @param ValidatorResolver $validatorResolver Application ValidatorResolver
	 * @param GenericObjectValidator $validator GenericObjectValidator
	 */
	public function __construct(
		ValidatorResolver $validatorResolver,
		GenericObjectValidator $validator
	) {
		$this->validatorResolver = $validatorResolver;
		$this->validator = $validator;
	}

	/**
	 * Adds the internal validator object to the incoming argument validator
	 *
	 * @param ConjunctionValidator $argumentValidator The validator to extend
	 *
	 * @return void
	 */
	public function addTo(ConjunctionValidator $argumentValidator) {
		$this->addPropertiesValidator();
		$this->addPersonValidator();
		$this->addMessageValidator();

		$argumentValidator->addValidator($this->validator);
	}

	/**
	 * Adds the validation for first-level properties
	 * @return void
	 */
	protected function addPropertiesValidator() {
		$this->validator->addPropertyValidator('creationDate', $this->getNotEmptyValidator());
		$this->validator->addPropertyValidator('creationDate', $this->getTimestampDeltaValidator());
	}

	/**
	 * Adds the validation for the person DO
	 *
	 * @return void
	 */
	protected function addPersonValidator() {
		$validator = $this->getGenericObjectValidator();
		$validator->addPropertyValidator('firstName', $this->getNotEmptyValidator());
		$validator->addPropertyValidator('email', $this->getEmailAddressValidator());
		$validator->addPropertyValidator('city', $this->getBlankValidator());

		$this->validator->addPropertyValidator('person', $validator);
	}

	/**
	 * Adds the validation for the message DO
	 *
	 * @return void
	 */
	protected function addMessageValidator() {
		$validator = $this->getGenericObjectValidator();
		$validator->addPropertyValidator('subject', $this->getNotEmptyValidator());
		$validator->addPropertyValidator('message', $this->getNotEmptyValidator());
		$validator->addPropertyValidator('message', $this->getUrlThresholdValidator());

		$this->validator->addPropertyValidator('message', $validator);
	}

	/**
	 * Returns a generic object validator
	 *
	 * @return GenericObjectValidator
	 */
	private function getGenericObjectValidator() {
		return $this->getValidatorFromResolver('GenericObject');
	}

	/**
	 * Returns a NotEmptyValidator
	 *
	 * @return NotEmptyValidator
	 */
	private function getNotEmptyValidator() {
		return $this->getValidatorFromResolver('NotEmpty');
	}

	/**
	 * Returns a EmailAddressValidator
	 *
	 * @return EmailAddressValidator
	 */
	private function getEmailAddressValidator() {
		return $this->getValidatorFromResolver('EmailAddress');
	}

	/**
	 * Returns the BlankValidator
	 *
	 * @return BlankValidator
	 */
	private function getBlankValidator() {
		return $this->getValidatorFromResolver('DreadLabs.Vantomas:BlankValidator');
	}

	/**
	 * Returns the DateTimeDeltaValidator
	 *
	 * @return DateTimeDeltaValidator
	 */
	private function getTimestampDeltaValidator() {
		return $this->getValidatorFromResolver('DreadLabs.Vantomas:DateTimeDeltaValidator');
	}

	/**
	 * Returns the UrlThresholdValidator
	 *
	 * @return UrlThresholdValidator
	 */
	private function getUrlThresholdValidator() {
		return $this->getValidatorFromResolver('DreadLabs.Vantomas:UrlThresholdValidator');
	}

	/**
	 * See ValidatorResolver::createValidator() for more information
	 *
	 * @param string $type Shorthand notation of an application validator
	 * @param array $options Options for the validator instance
	 *
	 * @return ValidatorInterface
	 */
	private function getValidatorFromResolver($type, array $options = array()) {
		return $this->validatorResolver->createValidator($type, $options);
	}
}
