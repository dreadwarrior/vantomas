<?php
namespace DreadLabs\Vantomas\Mailer;

use DreadLabs\VantomasWebsite\Mailer\ConfigurationInterface;
use DreadLabs\VantomasWebsite\Mailer\FailedRecipientsException;
use DreadLabs\VantomasWebsite\Mailer\MessageInterface;
use DreadLabs\VantomasWebsite\Mailer\TemplateInterface;
use TYPO3\CMS\Core\Mail\MailMessage;

class MailMessageAdapter implements MessageInterface {

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
	 * @param TemplateInterface $template
	 * @return void
	 */
	public function setSubject(TemplateInterface $template) {
		$this->message->setSubject($template->getSubject());
	}

	/**
	 * @param TemplateInterface $template
	 * @return void
	 */
	public function setHtmlBody(TemplateInterface $template) {
		$this->message->setBody($template->getHtmlBody(), 'text/html', 'utf8');
	}

	/**
	 * @param TemplateInterface $template
	 * @return void
	 */
	public function setTextBody(TemplateInterface $template) {
		$this->message->addPart($template->getPlainBody(), 'text/plain');
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