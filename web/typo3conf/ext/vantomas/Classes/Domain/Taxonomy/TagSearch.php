<?php
namespace DreadLabs\Vantomas\Domain\Taxonomy;

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

use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\Taxonomy\Tag;
use DreadLabs\VantomasWebsite\Taxonomy\TagSearchInterface;
use Traversable;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Tag search impl
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TagSearch implements TagSearchInterface {

	/**
	 * The Tag to search for
	 *
	 * @var Tag
	 */
	private $tag;

	/**
	 * Sets the Tag of the search instance
	 *
	 * @param Tag $tag Tag to search for
	 *
	 * @return void
	 */
	public function setTag(Tag $tag) {
		$this->tag = $tag;
	}

	/**
	 * String representation of the search instance
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->tag->getValue();
	}
}
