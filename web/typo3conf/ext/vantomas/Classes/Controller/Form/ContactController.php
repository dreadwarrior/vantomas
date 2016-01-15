<?php
namespace DreadLabs\Vantomas\Controller\Form;

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
use DreadLabs\VantomasWebsite\Form\Contact;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * ContactController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ContactController extends ActionController
{

    /**
     * ContactForm validation impl
     *
     * @var ContactFormValidation
     */
    private $contactFormValidation;

    /**
     * Injects the ContactForm validation impl
     *
     * @param ContactFormValidation $validation The validation impl
     *
     * @return void
     */
    public function injectContactFormValidation(ContactFormValidation $validation)
    {
        $this->contactFormValidation = $validation;
    }

    /**
     * Initializes the action
     *
     * This will add the validation to the incoming `contact` argument
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException The
     * Exception is thrown if the action doesn't receives the `contact` parameter.
     */
    public function initializeAction()
    {
        $argumentValidator = $this->arguments->getArgument('contact')->getValidator();
        $this->contactFormValidation->addTo($argumentValidator);
    }

    /**
     * Initial display of the contact form
     *
     * @param Contact $contact The contact form
     *
     * @ignorevalidation $contact
     *
     * @return void
     */
    public function newAction(Contact $contact = null)
    {
        if (is_null($contact)) {
            $contact = $this->objectManager->get(Contact::class);
        }

        $this->view->assign('contact', $contact);
    }

    /**
     * Sends contact form
     *
     * @param Contact $contact The Contact form
     *
     * @validate $contact DreadLabs.Vantomas:NotBlankUserAgentValidator
     * @validate $contact DreadLabs.Vantomas:RefererHostEqualityValidator
     *
     * @return void
     */
    public function sendAction(Contact $contact)
    {
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'send', [$contact]);

        $this->redirect('success', null, null, null, $this->settings['targetPid']);
    }
}
