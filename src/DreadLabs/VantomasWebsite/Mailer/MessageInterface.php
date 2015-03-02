<?php
namespace DreadLabs\VantomasWebsite\Mailer;

use DreadLabs\VantomasWebsite\Mailer\FailedRecipientsException;

interface MessageInterface {

	/**
	 * @param TemplateInterface $template
	 * @return void
	 */
	public function setSubject(TemplateInterface $template);

	/**
	 * @param TemplateInterface $template
	 * @return void
	 */
	public function setHtmlBody(TemplateInterface $template);

	/**
	 * @param TemplateInterface $template
	 * @return void
	 */
	public function setTextBody(TemplateInterface $template);

	/**
	 * Returns false on error
	 *
	 * @return void
	 * @throws FailedRecipientsException
	 */
	public function send();
}