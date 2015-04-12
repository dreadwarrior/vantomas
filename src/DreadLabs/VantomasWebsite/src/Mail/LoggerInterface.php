<?php
namespace DreadLabs\VantomasWebsite\Mail;

interface LoggerInterface {

	/**
	 * @param string $message
	 * @param array $context
	 * @return void
	 */
	public function alert($message, array $context = array());
}