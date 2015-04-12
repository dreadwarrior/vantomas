<?php
namespace DreadLabs\VantomasWebsite\Mail\Message;

use DreadLabs\VantomasWebsite\Mail\MessageInterface;

interface ViewInterface {

	/**
	 * @param $template
	 * @return void
	 */
	public function setTemplate($template);

	/**
	 * @param array $variables
	 * @return void
	 */
	public function setVariables(array $variables);

	/**
	 * @param MessageInterface $message
	 * @return void
	 */
	public function render(MessageInterface $message);
}