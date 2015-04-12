<?php
namespace DreadLabs\VantomasWebsite\Taxonomy;

use DreadLabs\VantomasWebsite\Page\Page;

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