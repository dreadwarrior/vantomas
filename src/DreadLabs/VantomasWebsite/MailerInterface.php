<?php
namespace DreadLabs\VantomasWebsite;

use DreadLabs\VantomasWebsite\Mailer\ConveyableInterface;
use DreadLabs\VantomasWebsite\Mailer\Exception\FailedRecipientsException;

interface MailerInterface {

	/**
	 * @param ConveyableInterface $conveyable
	 * @return void
	 * @throws FailedRecipientsException
	 */
	public function send(ConveyableInterface $conveyable);
}