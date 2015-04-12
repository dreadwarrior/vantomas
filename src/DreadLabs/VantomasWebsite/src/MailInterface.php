<?php
namespace DreadLabs\VantomasWebsite;

use DreadLabs\VantomasWebsite\Mail\ConveyableInterface;
use DreadLabs\VantomasWebsite\Mail\Exception\FailedRecipientsException;

interface MailInterface {

	/**
	 * @param ConveyableInterface $conveyable
	 * @return void
	 * @throws FailedRecipientsException
	 */
	public function convey(ConveyableInterface $conveyable);
}