<?php
namespace DreadLabs\Vantomas\Controller;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Thomas Juhnke <typo3@van-tomas.de>
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

use DreadLabs\VantomasWebsite\ContactForm;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * A controller for various forms
 *
 * @package \DreadLabs\Vantomas\Controller
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class FormController extends ActionController {

	/**
	 * Initial display of the contact form
	 *
	 * @param \DreadLabs\VantomasWebsite\ContactForm $contactForm
	 * @ignorevalidation $contactForm
	 * @return void
	 */
	public function newContactAction(ContactForm $contactForm = NULL) {
		if (is_null($contactForm)) {
			$contactForm = $this->objectManager->get(
				'DreadLabs\\VantomasWebsite\\ContactForm'
			);
		}

		$this->view->assign('contactForm', $contactForm);
	}

	/**
	 * Sends contact form
	 *
	 * @param \DreadLabs\VantomasWebsite\ContactForm $contactForm
	 * @validate $contactForm \DreadLabs\Vantomas\Validation\Validator\ContactFormAntiSpamValidator
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