<?php
namespace DreadLabs\VantomasWebsite\Tests\Fixture\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Client\AbstractClient;
use DreadLabs\VantomasWebsite\Disqus\ResourceInterface;

class DummyConcreteClient extends AbstractClient {

	public function connectTo(ResourceInterface $resource) {

	}

	public function getResponse() {

	}

	public function disconnect() {

	}
}