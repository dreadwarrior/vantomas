<?php
namespace DreadLabs\VantomasWebsite\Mailer;

interface TemplateInterface {

	/**
	 * @param array $variables
	 * @return void
	 */
	public function setVariables(array $variables);

	/**
	 * @return string
	 */
	public function getSubject();

	/**
	 * @return string
	 */
	public function getHtmlBody();

	/**
	 * @return string
	 */
	public function getPlainBody();
}