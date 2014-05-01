<?php
namespace DreadLabs\Vantomas\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (typo3@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * PageStatisticsController implements page statistics functionality
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PageStatisticsController extends ActionController {

	/**
	 *
	 * @var \DreadLabs\Vantomas\Domain\Repository\PageRepository
	 */
	protected $pageRepository = NULL;

	/**
	 *
	 * @param \DreadLabs\Vantomas\Domain\Repository\PageRepository $pageRepository
	 * @return void
	 */
	public function injectPageRepository(\DreadLabs\Vantomas\Domain\Repository\PageRepository $pageRepository) {
		$this->pageRepository = $pageRepository;
	}

	public function mostPopularAction() {
		$storagePid = (integer) $this->settings['storagePid'];
		$limit = (integer) $this->settings['limit'];

		$pages = $this
			->pageRepository
			->findMostPopular($storagePid, $limit);

		$this->view->assign('pages', $pages);
	}

	public function lastUpdatedAction() {
		$storagePid = $this->settings['storagePid'];
		$offset = (integer) $this->settings['offset'];
		$limit = (integer) $this->settings['limit'];

		$pages = $this
			->pageRepository
			->findLastUpdated($storagePid, $offset, $limit);

		$this->view->assign('pages', $pages);
	}
}