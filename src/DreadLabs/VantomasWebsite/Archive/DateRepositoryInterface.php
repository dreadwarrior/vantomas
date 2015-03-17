<?php
namespace DreadLabs\VantomasWebsite\Archive;

use Dreadlabs\VantomasWebsite\Page\PageId;

interface DateRepositoryInterface {

	/**
	 * Finds archive dates
	 *
	 * @param PageId $parentPageId
	 * @return Date[]
	 */
	public function find(PageId $parentPageId);
}