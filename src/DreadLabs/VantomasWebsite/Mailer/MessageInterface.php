<?php
namespace DreadLabs\VantomasWebsite\Mailer;

use DreadLabs\VantomasWebsite\Mailer\Exception\FailedRecipientsException;

interface MessageInterface {

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