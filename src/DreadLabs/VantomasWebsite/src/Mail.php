<?php
namespace DreadLabs\VantomasWebsite;

use DreadLabs\VantomasWebsite\Mail\ComposerInterface;
use DreadLabs\VantomasWebsite\Mail\ConveyableInterface;
use DreadLabs\VantomasWebsite\Mail\Exception\FailedRecipientsException;
use DreadLabs\VantomasWebsite\Mail\LoggerInterface;

class Mail implements MailInterface {

	/**
	 * @var ComposerInterface
	 */
	private $composer;

	/**
	 *
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 *
	 * @param ComposerInterface $composer
	 * @param LoggerInterface $logger
	 */
	public function __construct(
		ComposerInterface $composer,
		LoggerInterface $logger
	) {
		$this->composer = $composer;
		$this->logger = $logger;
	}

	/**
	 *
	 * @param ConveyableInterface $conveyable
	 */
	public function convey(ConveyableInterface $conveyable) {
		try {
			$message = $this->composer->compose($conveyable);
			$message->send();
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