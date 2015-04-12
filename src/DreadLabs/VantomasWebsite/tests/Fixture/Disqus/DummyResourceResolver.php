<?php
namespace DreadLabs\VantomasWebsite\Tests\Fixture\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Resource\AbstractResource;
use DreadLabs\VantomasWebsite\Disqus\Resource\ResolverInterface;

class DummyResourceResolver implements ResolverInterface {

	/**
	 * Resolves a concrete resource by topic + action
	 *
	 * @param string $topic
	 * @param string $action
	 * @return AbstractResource
	 */
	public function resolve($topic, $action) {
		// TODO: Implement resolve() method.
	}
}