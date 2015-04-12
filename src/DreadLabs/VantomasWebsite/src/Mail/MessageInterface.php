<?php
namespace DreadLabs\VantomasWebsite\Mail;

use DreadLabs\VantomasWebsite\Mail\Exception\FailedRecipientsException;

interface MessageInterface {

	/**
	 * @param array $sender
	 * @return void
	 */
	public function setSender(array $sender);

	/**
	 * @param $receiver
	 * @return void
	 */
	public function setReceiver(array $receiver);

	/**
	 * @param string $subject
	 * @return void
	 */
	public function setSubject($subject);

	/**
	 * @param string $htmlBody
	 * @return void
	 */
	public function setHtmlBody($htmlBody);

	/**
	 * @param string $plainBody
	 * @return void
	 */
	public function setPlainBody($plainBody);

	/**
	 * @return void
	 * @throws FailedRecipientsException
	 */
	public function send();
}