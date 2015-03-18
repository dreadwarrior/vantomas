<?php
namespace DreadLabs\VantomasWebsite\Page;

interface PageIdCollectionInterface extends \Countable, \ArrayAccess, \IteratorAggregate {

	/**
	 * @param array $pageIds
	 * @return self
	 */
	public static function createFromNative(array $pageIds);

	/**
	 * @param PageId $pageId
	 * @return void
	 */
	public function add(PageId $pageId);

	/**
	 * @param PageId $pageId
	 * @return void
	 */
	public function remove(PageId $pageId);

	/**
	 * @return array
	 */
	public function toArray();
}