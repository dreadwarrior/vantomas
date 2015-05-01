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
	 * @var TypoScriptFrontendController
	 */
	private $typoScriptFrontendController;

	/**
	 * @var Tag
	 */
	private $tag;

	/**
	 * @var Page[]
	 */
	private $result;

	/**
	 * @return self
	 */
	public function __construct() {
		$this->typoScriptFrontendController = $GLOBALS['TSFE'];
	}

	/**
	 * @param Tag $tag
	 * @return void
	 */
	public function setTag(Tag $tag) {
		$this->tag = $tag;
	}

	/**
	 * @param Page[] $result
	 * @return void
	 */
	public function setResult(array $result) {
		$this->result = $result;
	}

	/**
	 * @return Page
	 */
	public function getCurrentPage() {
		return $this->typoScriptFrontendController->page;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->tag->getValue();
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 */
	public function getIterator() {
		return new \ArrayIterator($this->result);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 */
	public function count() {
		return count($this->result);
	}
}