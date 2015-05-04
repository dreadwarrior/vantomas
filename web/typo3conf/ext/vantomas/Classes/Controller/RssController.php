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
use DreadLabs\VantomasWebsite\RssFeed\ConfigurationInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * A controller for RSS feed generation
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class RssController extends ActionController {

	/**
	 * Page repository, used for all RSS related persistance layer queries
	 *
	 * @var PageRepositoryInterface
	 */
	protected $pageRepository;

	/**
	 * The RSS feed generation configuration
	 *
	 * @var ConfigurationInterface
	 */
	protected $configuration;

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
	 * Injects the RSS Feed configuation impl
	 *
	 * @param ConfigurationInterface $configuration RSS Feed configuration impl
	 *
	 * @return void
	 */
	public function injectConfiguration(ConfigurationInterface $configuration) {
		$this->configuration = $configuration;
	}

	/**
	 * Generates the RSS feed
	 *
	 * @return void
	 */
	public function feedAction() {
		$pages = $this->pageRepository->findAllForRssFeed($this->configuration);

		$this->view->assign('pages', $pages);
	}
}
