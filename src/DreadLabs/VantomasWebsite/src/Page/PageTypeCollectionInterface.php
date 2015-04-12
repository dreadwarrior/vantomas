<?php
namespace DreadLabs\VantomasWebsite\Page;

interface PageTypeCollectionInterface extends \Countable, \ArrayAccess, \IteratorAggregate {

	/**
	 * @param PageType $pageType
	 * @return void
	 */
	public function add(PageType $pageType);

	/**
	 * @param PageType $pageType
	 * @return void
	 */
	public function remove(PageType $pageType);

	/**
	 * @return array
	 */
	public function toArray();
}