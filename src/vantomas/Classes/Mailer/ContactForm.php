<?php
namespace DreadLabs\Vantomas\Mailer;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Tommy Juhnke <typo3@van-tomas.de>
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

use DreadLabs\Vantomas\Domain\Model\ContactForm;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * A mail handling controller
 *
 * @package \DreadLabs\Vantomas\Controller
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
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
	 * @var array
	 */
	protected $settings;

	/**
	 *
	 * @param StandaloneView $view
	 */
	public function injectView(StandaloneView $view) {
		$this->view = $view;
		$this->view->setTemplatePathAndFilename('/typo3conf/ext/vantomas/Resources/Private/Templates/Mail/ContactForm.html');
	}

	/**
	 *
	 * @param MailMessage $message
	 */
	public function injectMessage(MailMessage $message) {
		$this->message = $message;
	}

	/**
	 *
	 * @param ConfigurationManagerInterface $configurationManager
	 */
	public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager) {
		$configuration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

		$this->settings = $configuration['plugin.']['tx_vantomas.']['settings.']['mailer.'][get_class($this) . '.'];
	}

	/**
	 *
	 * @param ContactForm $contactForm
	 * @return void
	 */
	public function send(ContactForm $contactForm) {
		$this->message->setFrom($this->getAddressListFromTypoScript($this->settings['sender']));
		$this->message->setTo($this->getAddressListFromTypoScript($this->settings['receiver']));

		$this->view->assign('contactForm', $contactForm);

		$this->view->assign('Section', 'Subject');
		$subject = $this->view->render();

		$this->view->assign('Section', 'Body');
		$body = $this->view->render();

		$this->message->setBody($body, 'text/html', 'utf8');

		$this->message->send();
	}

	/**
	 *
	 * @param array $configuration
	 * @return array
	 */
	protected function getAddressListFromTypoScript(array $configuration) {
		$addressList = array();

		foreach ($configuration as $priority => $address) {
			$addressList[$priority] = array($address['mail'] => $address['name']);
		}

		return $addressList;
	}
}
?>