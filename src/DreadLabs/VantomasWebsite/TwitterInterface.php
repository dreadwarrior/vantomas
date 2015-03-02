<?php
namespace DreadLabs\VantomasWebsite;

interface TwitterInterface {

	public function addParameter($key, $value);

	public function getTimeline();

	public function getSearchResult();
}