<?php
namespace DreadLabs\VantomasWebsite\Sitemap;

use DreadLabs\VantomasWebsite\Page\PageIdCollectionInterface;

interface ConfigurationInterface {

	/**
	 * @return PageIdCollectionInterface
	 */
	public function getParentPageIds();

	/**
	 * @return PageIdCollectionInterface
	 */
	public function getExcludePageIds();
}