<?php
namespace DreadLabs\VantomasWebsite\Mailer;

interface ConfigurationInterface {

	/**
	 * @return string
	 */
	public function getMessageTemplate();

	/**
	 * @return array
	 */
	public function getSenderList();

	/**
	 * @return array
	 */
	public function getReceiverList();
}