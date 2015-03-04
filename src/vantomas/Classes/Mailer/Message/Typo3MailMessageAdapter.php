<?php
namespace DreadLabs\Vantomas\Mailer\Message;

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

use DreadLabs\VantomasWebsite\Mailer\ConfigurationInterface;
use DreadLabs\VantomasWebsite\Mailer\Exception\FailedRecipientsException;
use DreadLabs\VantomasWebsite\Mailer\MessageInterface;
use TYPO3\CMS\Core\Mail\MailMessage;

class Typo3MailMessageAdapter implements MessageInterface {

	/**
	 * @var ConfigurationInterface
	 */
	private $configuration;

	/**
	 * @var MailMessage
	 */
	private $message;

	public function __construct(
		ConfigurationInterface $configuration,
		MailMessage $message
	) {
		$this->configuration = $configuration;
		$this->message = $message;

		$this->initializeMessage();
	}

	private function initializeMessage() {
		$senderList = $this->configuration->getSenderList();
		$receiverList = $this->configuration->getReceiverList();

		$this->message->setFrom($senderList);
		$this->message->setTo($receiverList);
	}

	/**
	 * @param string $subject
	 * @return void
	 */
	public function setSubject($subject) {
		$this->message->setSubject($subject);
	}

	/**
	 * @param string $htmlBody
	 * @return void
	 */
	public function setHtmlBody($htmlBody) {
		$this->message->setBody($htmlBody, 'text/html', 'utf8');
	}

	/**
	 * @param string $plainBody
	 * @return void
	 */
	public function setPlainBody($plainBody) {
		$this->message->addPart($plainBody, 'text/plain');
	}

	/**
	 * Returns false on error
	 *
	 * @return int The number of recipients who were accepted for delivery
	 * @throws FailedRecipientsException
	 */
	public function send() {
		$acceptedRecipients = $this->message->send();

		$hasNoAcceptedRecipients = 0 === $acceptedRecipients;
		$hasFailedRecipients = count($this->message->getFailedRecipients()) > 0;

		if ($hasNoAcceptedRecipients || $hasFailedRecipients) {
			$e = new FailedRecipientsException();
			$e->setSenderList($this->configuration->getSenderList());
			$e->setReceiverList($this->configuration->getReceiverList());
			$e->setFailedRecipients($this->message->getFailedRecipients());

			throw $e;
		}
	}
}