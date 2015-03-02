<?php
namespace DreadLabs\VantomasWebsite\Twitter;

interface ConfigurationInterface {

	public function getUserAgent();

	public function getBearerCacheLifetime();

	public function getConsumerKey();

	public function getConsumerSecret();

	public function getBearerTokenUrl();
}