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
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * The provider content controller
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @route off
 */
class ContentController extends \FluidTYPO3\Fluidcontent\Controller\ContentController {

	/**
	 * Special action for the PageAbstract content template
	 *
	 * @return void
	 */
	public function pageAbstractAction() {
		$this->view->assign(
			'pageId',
			PageId::fromString($this->getTypoScriptFrontendController()->page['uid'])
		);
	}

	/**
	 * Returns the global TSFE instance
	 *
	 * @return TypoScriptFrontendController
	 */
	private function getTypoScriptFrontendController() {
		return $GLOBALS['TSFE'];
	}
}
