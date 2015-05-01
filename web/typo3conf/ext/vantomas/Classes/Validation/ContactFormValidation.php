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
		$this->addPropertiesValidator();
		$this->addPersonValidator();
		$this->addMessageValidator();

		$argumentValidator->addValidator($this->validator);
	}

	/**
	 * @return void
	 */
	protected function addPropertiesValidator() {
		$this->validator->addPropertyValidator('creationDate', $this->getNotEmptyValidator());
		$this->validator->addPropertyValidator('creationDate', $this->getTimestampDeltaValidator());
	}

	/**
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
	 * @return BlankValidator
	 */
	private function getBlankValidator() {
		return $this->getValidatorFromResolver('DreadLabs.Vantomas:BlankValidator');
	}

	/**
	 * @return DateTimeDeltaValidator
	 */
	private function getTimestampDeltaValidator() {
		return $this->getValidatorFromResolver('DreadLabs.Vantomas:DateTimeDeltaValidator');
	}

	/**
	 * @return UrlThresholdValidator
	 */
	private function getUrlThresholdValidator() {
		return $this->getValidatorFromResolver('DreadLabs.Vantomas:UrlThresholdValidator');
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
