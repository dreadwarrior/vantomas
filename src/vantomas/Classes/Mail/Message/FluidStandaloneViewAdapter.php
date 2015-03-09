<?php
namespace DreadLabs\Vantomas\Mail\Message;

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

use DreadLabs\VantomasWebsite\Mail\MessageInterface;
use DreadLabs\VantomasWebsite\Mail\Message\ViewInterface;
use TYPO3\CMS\Install\View\StandaloneView;

class FluidStandaloneViewAdapter implements ViewInterface {

	/**
	 * @var StandaloneView
	 */
	private $view;

	/**
	 * @param StandaloneView $view
	 */
	public function __construct(
		StandaloneView $view
	) {
		$this->view = $view;
	}

	/**
	 * @param string $template
	 * @return void
	 */
	public function setTemplate($template) {
		$this->view->setTemplatePathAndFilename($template);
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
		$message->setSubject($this->renderSection('Subject'));
		$message->setHtmlBody($this->renderSection('BodyHtml'));
		$message->setPlainBody($this->renderSection('BodyText'));
	}

	/**
	 * @param $section
	 * @return string
	 */
	private function renderSection($section) {
		$this->view->assign('Section', $section);

		return trim($this->view->render());
	}
}