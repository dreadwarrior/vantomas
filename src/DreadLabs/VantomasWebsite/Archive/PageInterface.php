<?php
namespace DreadLabs\VantomasWebsite\Archive;

interface PageInterface {

	/**
	 * @return int
	 */
	public function getYear();

	/**
	 * @return int
	 */
	public function getMonth();

	/**
	 * @return \DateTime
	 */
	public function getLastUpdatedAt();
}