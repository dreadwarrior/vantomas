<?php
namespace DreadLabs\VantomasWebsite\Tests\Fixture\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Client\ResolverInterface;

class DummyClientResolver implements ResolverInterface {

	/**
	 * {@inheritdoc}
	 */
	public function resolve($clientName) {
	}
}