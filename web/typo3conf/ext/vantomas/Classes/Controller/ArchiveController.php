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
	 * Date repository, used for list action
	 *
	 * @var DateRepositoryInterface
	 */
	protected $dateRepository;

	/**
	 * Page repository, used for search action
	 *
	 * @var PageRepositoryInterface
	 */
	protected $pageRepository;

	/**
	 * Search VO
	 *
	 * @var SearchInterface
	 */
	private $search;

	/**
	 * Injects the date repository
	 *
	 * @param DateRepositoryInterface $dateRepository DateRepository impl
	 *
	 * @return void
	 */
	public function injectDateRepository(DateRepositoryInterface $dateRepository) {
		$this->dateRepository = $dateRepository;
	}

	/**
	 * Injects the page repository
	 *
	 * @param PageRepositoryInterface $pageRepository PageRepository impl
	 *
	 * @return void
	 */
	public function injectPageRepository(PageRepositoryInterface $pageRepository) {
		$this->pageRepository = $pageRepository;
	}

	/**
	 * Injects the archive search VO
	 *
	 * @param SearchInterface $search The search VO impl
	 *
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
	 * @param string $month Month, numeric 1-12
	 * @param int $year Year, numeric yyyy
	 *
	 * @ignorevalidation $month
	 * @ignorevalidation $year
	 *
	 * @return void
	 */
	public function searchAction($month, $year) {
		$this->search->setDateRange(DateRange::fromMonthAndYear($month, $year));
		$this->search->setPageType(PageType::fromString($this->settings['pageType']));

		$pages = $this->pageRepository->findArchived($this->search);

		$this->view->assign('pages', $pages);
		$this->view->assign('search', $this->search);
	}
}
