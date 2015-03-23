<?php
namespace DreadLabs\VantomasWebsite\Taxonomy;

interface TagManagerInterface {

	/**
	 * @return TagCloudInterface
	 */
	public function getCloud();

}