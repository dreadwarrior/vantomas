<?php
namespace DreadLabs\VantomasWebsite\Mail;

use DreadLabs\VantomasWebsite\Mail\Message\ViewInterface;

interface ConveyableInterface {

	/**
	 * @param ViewInterface $view
	 * @return void
	 */
	public function setMailMessageViewData(ViewInterface $view);

}