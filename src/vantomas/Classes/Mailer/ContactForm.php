<?php
namespace DreadLabs\Vantomas\Mailer;

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

use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;

/**
 * A mail handling controller
 *
 * @package \DreadLabs\Vantomas\Controller
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class ContactForm {

	/**
	 *
	 * @var StandaloneView
	 */
	protected $view;

	/**
	 *
	 * @var MailMessage
	 */
	protected $message;

	/**
	 *
	 * @var Logger
	 */
	protected $logger;

	/**
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * Injects the view
	 *
	 * @param StandaloneView $view
	 * @return void
	 */
	public function injectView(StandaloneView $view) {
		$this->view = $view;
		$this->view->setTemplatePathAndFilename('typo3conf/ext/vantomas/Resources/Private/Templates/Mail/ContactForm.html');
	}

	/**
	 * Injects the massage
	 *
	 * @param MailMessage $message
	 * @return void
	 */
	public function injectMessage(MailMessage $message) {
		$this->message = $message;
	}

	/**
	 * Injects the log manager
	 *
	 * @param LogManager $logManager
	 * @return void
	 */
	public function injectLogManager(LogManager $logManager) {
		$this->logger = $logManager->getLogger(__CLASS__);
	}

	/**
	 * Injects the configuration manager
	 *
	 * @param ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager) {
		$configuration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

		$this->settings = $configuration['plugin.']['tx_vantomas.']['settings.']['mailer.'][get_class($this) . '.'];
	}

	/**
	 * Sends the contact form mail
	 *
	 * @param \DreadLabs\Vantomas\Domain\Model\ContactForm $contactForm
	 */
	public function send(\DreadLabs\Vantomas\Domain\Model\ContactForm $contactForm) {
		$senderList = $this->getAddressListFromTypoScript($this->settings['sender.']);
		$receiverList = $this->getAddressListFromTypoScript($this->settings['receiver.']);

		$this->message->setFrom($senderList);
		$this->message->setTo($receiverList);

		$this->view->assign('contactForm', $contactForm);

		$this->view->assign('Section', 'Subject');
		$subject = $this->view->render();

		$this->view->assign('Section', 'BodyHtml');
		$bodyHtml = $this->view->render();

		$this->view->assign('Section', 'BodyText');
		$bodyText = $this->view->render();

		$this->message->setSubject(trim($subject));
		$this->message->setBody(trim($bodyHtml), 'text/html', 'utf8');
		$this->message->addPart(trim($bodyText), 'text/plain');

		if (!$this->message->send()) {
			$this->logger->alert('The mail could not been sent.',
				array(
					'sender' => $senderList,
					'receiver' => $receiverList,
					'failedRecipients' => $this->message->getFailedRecipients(),
				)
			);
		}
	}

	/**
	 * Returns addresses from typoscript configuration
	 *
	 * @param array $configuration
	 * @return array
	 */
	protected function getAddressListFromTypoScript(array $configuration) {
		$addressList = array();

		foreach ($configuration as $address) {
			$addressList[$address['mail']] = $address['name'];
		}

		return $addressList;
	}
}