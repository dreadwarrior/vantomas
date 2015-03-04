<?php
namespace DreadLabs\VantomasWebsite\Mailer;

interface ConveyableInterface {

	/**
	 * @param TemplateInterface $template
	 * @return void
	 */
	public function prepareForMailTemplate(TemplateInterface $template);
}