<?php
namespace DreadLabs\VantomasWebsite\Archive;

use DreadLabs\VantomasWebsite\Page\PageType;

interface DateRepositoryInterface {

	/**
	 * Finds archive dates
	 *
	 * @param PageType $pageType
	 * @return Date[]
	 */
	public function find(PageType $pageType);
}