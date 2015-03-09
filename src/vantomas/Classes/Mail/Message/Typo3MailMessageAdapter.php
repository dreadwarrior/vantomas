<?php
namespace DreadLabs\Vantomas\Mail\Message;

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

use DreadLabs\VantomasWebsite\Mail\Exception\FailedRecipientsException;
use DreadLabs\VantomasWebsite\Mail\MessageInterface;
use TYPO3\CMS\Core\Mail\MailMessage;

class Typo3MailMessageAdapter implements MessageInterface {

	/**
	 * @var MailMessage
	 */
	private $message;

	public function __construct(
		MailMessage $message
	) {
		$this->message = $message;
	}

	/**
	 * @param array $sender
	 * @return void
	 */
	public function setSender(array $sender) {
		$this->message->setFrom($sender);
	}

	/**
	 * @param array $receiver
	 * @return void
	 */
	public function setReceiver(array $receiver) {
		$this->message->setTo($receiver);
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
			$e->setSenderList((array) $this->message->getSender());
			$e->setReceiverList($this->message->getTo());
			$e->setFailedRecipients($this->message->getFailedRecipients());

			throw $e;
		}
	}
}