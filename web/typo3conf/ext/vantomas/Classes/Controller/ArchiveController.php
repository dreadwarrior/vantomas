<?php
namespace DreadLabs\Vantomas\Controller;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Thomas Juhnke (typo3@van-tomas.de)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\VantomasWebsite\Archive\DateRange;
use DreadLabs\VantomasWebsite\Archive\DateRepositoryInterface;
use DreadLabs\VantomasWebsite\Archive\SearchInterface;
use DreadLabs\VantomasWebsite\Page\PageId;
use DreadLabs\VantomasWebsite\Page\PageRepositoryInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * ArchiveController - gives archive functionality
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ArchiveController extends ActionController {

	/**
	 *
	 * @var DateRepositoryInterface
	 */
	protected $dateRepository;

	/**
	 * @var PageRepositoryInterface
	 */
	protected $pageRepository;

	/**
	 * @var SearchInterface
	 */
	private $search;

	/**
	 * @param DateRepositoryInterface $dateRepository
	 * @return void
	 */
	public function injectDateRepository(DateRepositoryInterface $dateRepository) {
		$this->dateRepository = $dateRepository;
	}

	/**
	 * @param PageRepositoryInterface $pageRepository
	 * @return void
	 */
	public function injectPageRepository(PageRepositoryInterface $pageRepository) {
		$this->pageRepository = $pageRepository;
	}

	/**
	 * @param SearchInterface $search
	 * @return void
	 */
	public function injectSearch(SearchInterface $search) {
		$this->search = $search;
	}

	/**
	 * Archive listing
	 *
	 * @return void
	 */
	public function listAction() {
		$dates = $this
			->dateRepository
			->find(PageId::fromString($this->settings['storagePid']));

		$this->view->assign('dates', $dates);
	}

	/**
	 * Performs archive search
	 *
	 * @param string $month
	 * @param integer $year
	 * @ignorevalidation $month
	 * @ignorevalidation $year
	 * @return void
	 */
	public function searchAction($month, $year) {
		$this->search->setDateRange(DateRange::fromMonthAndYear($month, $year));
		$this->search->setParentPageId(PageId::fromString($this->settings['storagePid']));

		$pages = $this->pageRepository->findArchived($this->search);

		$this->search->setResult($pages);

		$this->view->assign('search', $this->search);
	}
}