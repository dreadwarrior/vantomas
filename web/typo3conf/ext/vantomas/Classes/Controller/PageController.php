<?php
namespace DreadLabs\Vantomas\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use DreadLabs\VantomasWebsite\Page\PageId;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * The provider page controller
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @route off
 */
class PageController extends \FluidTYPO3\Fluidpages\Controller\PageController {

	/**
	 * Initializes the view for all pages
	 *
	 * @param ViewInterface $view ViewInterface
	 *
	 * @return void
	 */
	public function initializeView(ViewInterface $view) {
		parent::initializeView($view);

		$applicationContext = GeneralUtility::getApplicationContext();
		$now = new \DateTime('now');

		$this->view->assign('isApplicationContext', array(
			'development' => $applicationContext->isDevelopment(),
			'testing' => $applicationContext->isTesting(),
			'production' => $applicationContext->isProduction(),
		));
		$this->view->assign('now', $now);
	}

	/**
	 * Special action for the blog page template
	 *
	 * @return void
	 */
	public function blogAction() {
		$this->view->assign(
			'pageId',
			PageId::fromString($GLOBALS['TSFE']->id)
		);
	}

	/**
	 * Special action for the standard page template
	 *
	 * @return void
	 */
	public function standardAction() {
	}

	/**
	 * Special action for the wide page template
	 *
	 * @return void
	 */
	public function wideAction() {
	}
}
