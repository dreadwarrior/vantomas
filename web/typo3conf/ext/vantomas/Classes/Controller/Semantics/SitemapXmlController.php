<?php
namespace DreadLabs\Vantomas\Controller\Semantics;

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

use DreadLabs\Vantomas\Mvc\Controller\AbstractPageRepositoryAwareController;
use DreadLabs\VantomasWebsite\Page\PageRepositoryInterface;
use DreadLabs\VantomasWebsite\Sitemap\ConfigurationInterface;

/**
 * Provides sitemap xml generation
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SitemapXmlController extends AbstractPageRepositoryAwareController {

	/**
	 * Generating a sitemap.xml needs its own configuration
	 *
	 * @var ConfigurationInterface
	 */
	protected $configuration;

	/**
	 * Injects the sitemap.xml Configuration impl
	 *
	 * @param ConfigurationInterface $configuration Configuration impl
	 *
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
	public function generateAction() {
		$pages = $this->pageRepository->findForSitemapXml($this->configuration);

		$this->view->assign('pages', $pages);
	}
}
