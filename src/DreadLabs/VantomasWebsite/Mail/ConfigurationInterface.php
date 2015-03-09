<?php
namespace DreadLabs\VantomasWebsite\Mail;

use DreadLabs\VantomasWebsite\Mail\Message\ViewInterface;

interface ConfigurationInterface {

	/**
	 * @param ConveyableInterface $conveyable
	 * @return void
	 */
	public function initializeFor(ConveyableInterface $conveyable);

	/**
	 * @param ViewInterface $view
	 * @return void
	 */
	public function configureView(ViewInterface $view);

	/**
	 * @param MessageInterface $message
	 * @return void
	 */
	public function configureMessage(MessageInterface $message);
}