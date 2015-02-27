<?php
namespace DreadLabs\VantomasWebsite\Twitter;

interface ConfigurationInterface {

	const CONFIGURATION_ROOT = 'twitter';

	public function getUserAgent();

	public function getBearerCacheLifetime();

	public function getConsumerKey();

	public function getConsumerSecret();

	public function getBearerTokenUrl();
}