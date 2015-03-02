<?php
namespace DreadLabs\VantomasWebsite\Mailer;

interface ConfigurationInterface {

	/**
	 * @return array
	 */
	public function getSenderList();

	/**
	 * @return array
	 */
	public function getReceiverList();
}