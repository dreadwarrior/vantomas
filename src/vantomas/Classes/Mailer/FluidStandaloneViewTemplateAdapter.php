<?php
namespace DreadLabs\Vantomas\Mailer;

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Thomas Juhnke <typo3@van-tomas.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\VantomasWebsite\Mailer\ConfigurationInterface;
use DreadLabs\VantomasWebsite\Mailer\MessageInterface;
use DreadLabs\VantomasWebsite\Mailer\TemplateInterface;
use TYPO3\CMS\Install\View\StandaloneView;

class FluidStandaloneViewTemplateAdapter implements TemplateInterface {

	/**
	 * @var StandaloneView
	 */
	private $view;

	/**
	 * @param ConfigurationInterface $configuration
	 * @param StandaloneView $view
	 */
	public function __construct(
		ConfigurationInterface $configuration,
		StandaloneView $view
	) {
		$this->view = $view;
		$this->view->setTemplatePathAndFilename(
			$configuration->getMessageTemplate()
		);
	}

	/**
	 * @param array $variables
	 * @return void
	 */
	public function setVariables(array $variables) {
		$this->view->assignMultiple($variables);
	}

	/**
	 * @param MessageInterface $message
	 * @return void
	 */
	public function render(MessageInterface $message) {
		$message->setSubject($this->getSubject());
		$message->setHtmlBody($this->getHtmlBody());
		$message->setPlainBody($this->getPlainBody());
	}

	/**
	 * @return string
	 */
	private function getSubject() {
		$this->view->assign('Section', 'Subject');
		return trim($this->view->render());
	}


	/**
	 * @return string
	 */
	private function getHtmlBody() {
		$this->view->assign('Section', 'BodyHtml');
		return trim($this->view->render());
	}

	/**
	 * @return string
	 */
	private function getPlainBody() {
		$this->view->assign('Section', 'BodyText');
		return trim($this->view->render());
	}
}