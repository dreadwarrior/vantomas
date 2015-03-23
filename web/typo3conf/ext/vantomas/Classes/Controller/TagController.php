<?php
namespace DreadLabs\Vantomas\Controller;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Thomas Juhnke <typo3@van-tomas.de>
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

use DreadLabs\VantomasWebsite\Page\PageRepositoryInterface;
use DreadLabs\VantomasWebsite\Page\Tag;
use DreadLabs\VantomasWebsite\Taxonomy\TagManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Provides tag centric actions
 *
 * @package \DreadLabs\Vantomas\Controller
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class TagController extends ActionController {

	/**
	 *
	 * @var PageRepositoryInterface
	 */
	private $pageRepository;

	/**
	 * @var TagManagerInterface
	 */
	private $tagManager;

	/**
	 * @param PageRepositoryInterface $pageRepository
	 */
	public function injectPageRepository(PageRepositoryInterface $pageRepository) {
		$this->pageRepository = $pageRepository;
	}

	/**
	 * @param TagManagerInterface $tagManager
	 */
	public function injectTagManager(TagManagerInterface $tagManager) {
		$this->tagManager = $tagManager;
	}

	/**
	 * Generates a tag cloud
	 *
	 * @return void
	 */
	public function cloudAction() {
		$cloud = $this->tagManager->getCloud();
		$this->view->assign('cloud', $cloud);
	}

	/**
	 * Lists all pages with given $tag
	 *
	 * @param string $tag An urlencoded tag string
	 * @return void
	 */
	public function searchAction($tag) {
		$pages = $this->pageRepository->findAllByTag(Tag::fromUrl($tag));

		/* @var $fe \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController */
		$fe = $GLOBALS['TSFE'];
		$currentPage = $fe->page;

		$this->view->assign('tag', $tag);
		$this->view->assign('pages', $pages);
		$this->view->assign('currentPage', $currentPage);
	}
}