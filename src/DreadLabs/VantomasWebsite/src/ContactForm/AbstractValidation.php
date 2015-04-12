<?php
namespace DreadLabs\VantomasWebsite\ContactForm;

/**
 * Abstract ContactForm validation contract
 */
abstract class AbstractValidation {

	/**
	 * @return void
	 */
	abstract protected function addPropertiesValidator();

	/**
	 * @return void
	 */
	abstract protected function addPersonValidator();

	/**
	 * @return void
	 */
	abstract protected function addMessageValidator();
}