<?php
namespace DreadLabs\VantomasWebsite\Disqus;


interface ConfigurationInterface {

	/**
	 * @return string
	 */
	public function getBaseUrl();

	/**
	 * @return string
	 */
	public function getApiKey();
}