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

use DreadLabs\VantomasWebsite\Archive\DateRange;
use DreadLabs\VantomasWebsite\Archive\DateRepositoryInterface;
use DreadLabs\VantomasWebsite\Archive\SearchInterface;
use DreadLabs\VantomasWebsite\Page\PageRepositoryInterface;
use DreadLabs\VantomasWebsite\Page\PageType;
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
			->find(PageType::fromString($this->settings['pageType']));

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
		$this->search->setPageType(PageType::fromString($this->settings['pageType']));

		$pages = $this->pageRepository->findArchived($this->search);

		$this->search->setResult($pages);

		$this->view->assign('search', $this->search);
	}
}