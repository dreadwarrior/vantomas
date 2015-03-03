<?php
namespace DreadLabs\VantomasWebsite\Mailer;

interface TemplateInterface {

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