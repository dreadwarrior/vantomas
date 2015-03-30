<?php
namespace DreadLabs\Vantomas\Controller;

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

use DreadLabs\Vantomas\Validation\ContactFormValidation;
use DreadLabs\VantomasWebsite\ContactForm;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * A controller for various forms
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FormController extends ActionController {

	/**
	 * @var ContactFormValidation
	 */
	private $contactFormValidation;

	/**
	 * @param ContactFormValidation $contactFormValidation
	 * @return void
	 */
	public function injectContactFormValidation(ContactFormValidation $contactFormValidation) {
		$this->contactFormValidation = $contactFormValidation;
	}

	/**
	 * @return void
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
	 */
	public function initializeAction() {
		$argumentValidator = $this->arguments->getArgument('contactForm')->getValidator();
		$this->contactFormValidation->addTo($argumentValidator);
	}

	/**
	 * Initial display of the contact form
	 *
	 * @param ContactForm $contactForm
	 * @ignorevalidation $contactForm
	 * @return void
	 */
	public function newContactAction(ContactForm $contactForm = NULL) {
		if (is_null($contactForm)) {
			$contactForm = $this->objectManager->get(ContactForm::class);
		}

		$this->view->assign('contactForm', $contactForm);
	}

	/**
	 * Sends contact form
	 *
	 * @param ContactForm $contactForm
	 * @validate $contactForm DreadLabs\Vantomas\Validation\Validator\ContactFormAntiSpamValidator
	 * @return void
	 */
	public function sendContactAction(ContactForm $contactForm) {
		$this->signalSlotDispatcher->dispatch(__CLASS__, 'sendContactForm', array($contactForm));

		$this->redirect('success', NULL, NULL, NULL, $this->settings['targetPid']);
	}

	/**
	 * Success action
	 *
	 * @return void
	 */
	public function successAction() {
	}
}