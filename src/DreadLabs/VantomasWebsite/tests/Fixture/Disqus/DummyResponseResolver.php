<?php
namespace DreadLabs\VantomasWebsite\Tests\Fixture\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Response\AbstractResponse;
use DreadLabs\VantomasWebsite\Disqus\Response\ResolverInterface;

class DummyResponseResolver implements ResolverInterface {

	/**
	 * @param string $format
	 * @return AbstractResponse
	 */
	public function resolve($format) {
		// TODO: Implement resolve() method.
	}
}