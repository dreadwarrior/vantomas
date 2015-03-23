<?php
namespace DreadLabs\VantomasWebsite\Taxonomy;

interface TagCloudInterface extends \Countable, \ArrayAccess, \IteratorAggregate {

	/**
	 * @param Tag $tag
	 * @return void
	 */
	public function add(Tag $tag);

	/**
	 * @param Tag $tag
	 * @return void
	 */
	public function remove(Tag $tag);

	/**
	 * @return array
	 */
	public function toArray();
}