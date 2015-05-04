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
	 * Message impl
	 *
	 * @var MailMessage
	 */
	private $message;

	/**
	 * Constructor
	 *
	 * @param MailMessage $message Message impl
	 */
	public function __construct(
		MailMessage $message
	) {
		$this->message = $message;
	}

	/**
	 * Sets the sender
	 *
	 * @param array $sender Sender list (mail -> name)
	 *
	 * @return void
	 */
	public function setSender(array $sender) {
		$this->message->setFrom($sender);
	}

	/**
	 * Sets the receiver
	 *
	 * @param array $receiver Receiver list (mail -> name)
	 *
	 * @return void
	 */
	public function setReceiver(array $receiver) {
		$this->message->setTo($receiver);
	}

	/**
	 * Sets the subject
	 *
	 * @param string $subject The subject
	 *
	 * @return void
	 */
	public function setSubject($subject) {
		$this->message->setSubject($subject);
	}

	/**
	 * Sets the HTML body
	 *
	 * @param string $htmlBody The HTML body
	 *
	 * @return void
	 */
	public function setHtmlBody($htmlBody) {
		$this->message->setBody($htmlBody, 'text/html', 'utf8');
	}

	/**
	 * Sets the plain body
	 *
	 * @param string $plainBody The plain body
	 *
	 * @return void
	 */
	public function setPlainBody($plainBody) {
		$this->message->addPart($plainBody, 'text/plain');
	}

	/**
	 * Sends the message
	 *
	 * @return void
	 * @throws FailedRecipientsException Is thrown if the
	 * underlying messaging service returns one or more failed
	 * recipients.
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
