<?php
namespace DreadLabs\Vantomas\Taxonomy;

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Thomas Juhnke <typo3@van-tomas.de>
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
use DreadLabs\VantomasWebsite\Taxonomy\TagCloudInterface;
use DreadLabs\VantomasWebsite\Taxonomy\TagManagerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TagManager implements TagManagerInterface {

	/**
	 * @var PageRepositoryInterface
	 */
	private $pageRepository;

	/**
	 * @var TagCloudInterface
	 */
	private $tagCloud;

	/**
	 * @param PageRepositoryInterface $pageRepository
	 * @param TagCloudInterface $tagCloud
	 */
	public function __construct(
		PageRepositoryInterface $pageRepository,
		TagCloudInterface $tagCloud
	) {
		$this->pageRepository = $pageRepository;
		$this->tagCloud = $tagCloud;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCloud() {
		$pages = $this->pageRepository->findAllWithTags();

		foreach ($pages as $page) {
			$pageTags = GeneralUtility::trimExplode(',', $page->getKeywords());
			foreach ($pageTags as $pageTag) {
				$this->tagCloud->add(Tag::fromString($pageTag));
			}
		}

		return $this->tagCloud;
	}
}