<?php
namespace DreadLabs\VantomasWebsite\Mailer;

interface LoggerInterface {

	/**
	 * @param string $message
	 * @param array $context
	 * @return void
	 */
	public function alert($message, array $context = array());
}