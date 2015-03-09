<?php
namespace DreadLabs\VantomasWebsite\Mail;

interface ComposerInterface {

	/**
	 * @param ConveyableInterface $conveyable
	 * @return MessageInterface
	 */
	public function compose(ConveyableInterface $conveyable);
}