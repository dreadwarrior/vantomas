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

use DreadLabs\VantomasWebsite\Sitemap\ConfigurationInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Provides sitemap xml generation
 *
 * @package \DreadLabs\Vantomas\Controller
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class SitemapController extends ActionController {

	/**
	 * @var PageRepositoryInterface
	 */
	protected $pageRepository;

	/**
	 * @var ConfigurationInterface
	 */
	protected $configuration;

	/**
	 * @param PageRepositoryInterface $pageRepository
	 * @return void
	 */
	public function injectPageRepository(PageRepositoryInterface $pageRepository) {
		$this->pageRepository = $pageRepository;
	}

	/**
	 * @param ConfigurationInterface $configuration
	 * @return void
	 */
	public function injectConfiguration(ConfigurationInterface $configuration) {
		$this->configuration = $configuration;
	}

	/**
	 * Generates an XML sitemap
	 *
	 * @return void
	 */
	public function xmlAction() {
		$pages = $this->pageRepository->findForSitemapXml($this->configuration);

		$this->view->assign('pages', $pages);
	}
}