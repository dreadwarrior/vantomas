<?php
namespace DreadLabs\VantomasWebsite\RssFeed;

use DreadLabs\VantomasWebsite\Page\PageIdCollectionInterface;
use DreadLabs\VantomasWebsite\Page\PageTypeCollectionInterface;

interface ConfigurationInterface {

	/**
	 * @return PageIdCollectionInterface
	 */
	public function getPageIds();

	/**
	 * @return PageTypeCollectionInterface
	 */
	public function getPageTypes();

	/**
	 * @return array
	 */
	public function getOrdering();
}