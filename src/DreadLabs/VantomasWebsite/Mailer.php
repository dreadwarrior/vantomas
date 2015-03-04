<?php
namespace DreadLabs\Vantomas\Mailer;

use DreadLabs\VantomasWebsite\Mailer\ConveyableInterface;
use DreadLabs\VantomasWebsite\Mailer\Exception\FailedRecipientsException;
use DreadLabs\VantomasWebsite\Mailer\LoggerInterface;
use DreadLabs\VantomasWebsite\Mailer\MessageInterface;
use DreadLabs\VantomasWebsite\Mailer\TemplateInterface;
use DreadLabs\VantomasWebsite\MailerInterface;

class Mailer implements MailerInterface {

	/**
	 *
	 * @var TemplateInterface
	 */
	protected $template;

	/**
	 *
	 * @var MessageInterface
	 */
	protected $message;

	/**
	 *
	 * @var LoggerInterface
	 */
	protected $logger;

	/**
	 *
	 * @param TemplateInterface $template
	 * @param MessageInterface $message
	 * @param LoggerInterface $logger
	 */
	public function __construct(
		TemplateInterface $template,
		MessageInterface $message,
		LoggerInterface $logger
	) {
		$this->template = $template;
		$this->message = $message;
		$this->logger = $logger;
	}

	/**
	 *
	 * @param ConveyableInterface $conveyable
	 */
	public function send(ConveyableInterface $conveyable) {
		try {
			$conveyable->prepareForMailTemplate($this->template);
			$this->template->render($this->message);
			$this->message->send();
		} catch (FailedRecipientsException $e) {
			$this->logger->alert('The mail could not been sent.',
				array(
					'sender' => $e->getSenderList(),
					'receiver' => $e->getReceiverList(),
					'failedRecipients' => $e->getFailedRecipients(),
				)
			);
		}
	}
}