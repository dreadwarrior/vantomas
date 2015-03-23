<?php
namespace DreadLabs\VantomasWebsite\Taxonomy;

use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\Page\Tag;

interface TagSearchInterface extends \IteratorAggregate, \Countable {

	/**
	 * @param Tag $tag
	 * @return void
	 */
	public function setTag(Tag $tag);

	/**
	 * @param Page[] $result
	 */
	public function setResult(array $result);

	/**
	 * @return Page
	 */
	public function getCurrentPage();

	/**
	 * @return string
	 */
	public function __toString();
}