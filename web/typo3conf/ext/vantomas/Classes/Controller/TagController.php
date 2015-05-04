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

use DreadLabs\VantomasWebsite\Page\PageRepositoryInterface;
use DreadLabs\VantomasWebsite\Taxonomy\Tag;
use DreadLabs\VantomasWebsite\Taxonomy\TagManagerInterface;
use DreadLabs\VantomasWebsite\Taxonomy\TagSearchInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Provides tag centric actions
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TagController extends ActionController {

	/**
	 * TagManager provides an API for tag / tag cloud specific queries
	 *
	 * @var TagManagerInterface
	 */
	private $tagManager;

	/**
	 * TagSearch needed for search action
	 *
	 * @var TagSearchInterface
	 */
	private $tagSearch;

	/**
	 * PageRepository, needed to query the persistence layer for tagged pages
	 *
	 * @var PageRepositoryInterface
	 */
	private $pageRepository;

	/**
	 * Injects the TagManager impl
	 *
	 * @param TagManagerInterface $tagManager TagManager impl
	 *
	 * @return void
	 */
	public function injectTagManager(TagManagerInterface $tagManager) {
		$this->tagManager = $tagManager;
	}

	/**
	 * Injects the TagSearch impl
	 *
	 * @param TagSearchInterface $tagSearch TagSearch impl
	 *
	 * @return void
	 */
	public function injectTagSearch(TagSearchInterface $tagSearch) {
		$this->tagSearch = $tagSearch;
	}

	/**
	 * Injects the PageRepository impl
	 *
	 * @param PageRepositoryInterface $pageRepository PageRepository impl
	 *
	 * @return void
	 */
	public function injectPageRepository(PageRepositoryInterface $pageRepository) {
		$this->pageRepository = $pageRepository;
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
	 *
	 * @return void
	 */
	public function searchAction($tag) {
		$this->tagSearch->setTag(Tag::fromUrl($tag));
		$pages = $this->pageRepository->findAllByTag($this->tagSearch);

		$this->view->assign('pages', $pages);
		$this->view->assign('search', $this->tagSearch);
	}
}
