<?php
namespace DreadLabs\Vantomas\Controller\Taxonomy;

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
use DreadLabs\VantomasWebsite\Taxonomy\Tag;

/**
 * TagSearchController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TagSearchController extends AbstractPageRepositoryAwareController {

	/**
	 * Lists all pages with given $tag
	 *
	 * @param string $tag An urlencoded tag string
	 *
	 * @return void
	 */
	public function listAction($tag) {
		$tag = Tag::fromUrl($tag);
		$pages = $this->pageRepository->findAllByTag($tag);

		$this->view->assign('pages', $pages);
		$this->view->assign('tag', $tag);
	}
}
