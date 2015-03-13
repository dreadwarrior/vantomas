<?php
namespace DreadLabs\VantomasWebsite\Tests\Fixture\Disqus;

use DreadLabs\VantomasWebsite\Disqus\ConfigurationInterface;

class DummyConfiguration implements ConfigurationInterface {

	/**
	 * @return string
	 */
	public function getBaseUrl() {
		return 'http://example.org';
	}

	/**
	 * @return string
	 */
	public function getApiKey() {
		return 'foo-bar-baz';
	}
}