<?php
namespace DreadLabs\Vantomas\Domain\Mail\Message;

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

use DreadLabs\VantomasWebsite\Mail\Exception\FailedRecipientsException;
use DreadLabs\VantomasWebsite\Mail\MessageInterface;
use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * The message adapter to the TYPO3.CMS mail message
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Typo3MailMessageAdapter implements MessageInterface {

	/**
	 * @var MailMessage
	 */
	private $message;

	/**
	 * @param MailMessage $message
	 * @return self
	 */
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
	 * @return void
	 * @throws FailedRecipientsException
	 */
	public function send() {
		$acceptedRecipients = $this->message->send();

		$noAcceptedRecipients = 0 === $acceptedRecipients;
		$hasFailedRecipients = count($this->message->getFailedRecipients()) > 0;

		if ($noAcceptedRecipients || $hasFailedRecipients) {
			$exc = new FailedRecipientsException();
			$exc->setSenderList((array) $this->message->getSender());
			$exc->setReceiverList($this->message->getTo());
			$exc->setFailedRecipients($this->message->getFailedRecipients());

			throw $exc;
		}
	}
}
