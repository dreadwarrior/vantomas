<?php
namespace DreadLabs\VantomasWebsite\Tests\Unit\Disqus;

class ClientTest extends \PHPUnit_Framework_TestCase {

	protected $clientResolver = NULL;

	protected $concreteClient = NULL;

	protected $resource = NULL;

	protected $response = NULL;

	public function setUp() {
		$this->clientResolver = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyClientResolver');

		$this->concreteClient = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyClient');

		$this->resource = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyResource');

		$this->response = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyResponse');
	}

	public function testClientResolverGivesConcreteClient() {

		$this->clientResolver
			->expects($this->once())
			->method('resolve')
			->with('dummy')
			->will($this->returnValue($this->concreteClient));

		$client = new \DreadLabs\VantomasWebsite\Disqus\Client(
			$this->clientResolver
		);

		$client->connectWith('dummy');
	}

	public function testResourceConnectionPassesResourceToConcreteClient() {

		$this->clientResolver
			->expects($this->once())
			->method('resolve')
			->with('dummy')
			->will($this->returnValue($this->concreteClient));

		$this->concreteClient
			->expects($this->once())
			->method('connectTo')
			->with($this->resource);

		$client = new \DreadLabs\VantomasWebsite\Disqus\Client(
			$this->clientResolver
		);

		$client->connectWith('dummy');
		$client->connectTo($this->resource);
	}

	public function testResponseFetchingFromConcreteClientOnSend() {

		$this->clientResolver
			->expects($this->once())
			->method('resolve')
			->with('dummy')
			->will($this->returnValue($this->concreteClient));

		$this->concreteClient
			->expects($this->once())
			->method('getResponse');

		$client = new \DreadLabs\VantomasWebsite\Disqus\Client(
			$this->clientResolver
		);

		$client->connectWith('dummy');
		$client->send();
	}

	public function testDisconnectIsProxiedToConcreteClient() {

		$this->clientResolver
			->expects($this->once())
			->method('resolve')
			->with('dummy')
			->will($this->returnValue($this->concreteClient));

		$this->concreteClient
			->expects($this->once())
			->method('disconnect');

		$client = new \DreadLabs\VantomasWebsite\Disqus\Client($this->clientResolver);

		$client->connectWith('dummy');
		$client->disconnect();
	}

	public function testResponseReturnsResponseObjectFetchedBySendMethod() {

		$this->clientResolver
			->expects($this->once())
			->method('resolve')
			->with('dummy')
			->will($this->returnValue($this->concreteClient));

		$this->concreteClient
			->expects($this->once())
			->method('getResponse')
			->will($this->returnValue($this->response));

		$client = new \DreadLabs\VantomasWebsite\Disqus\Client($this->clientResolver);

		$client->connectWith('dummy');
		$client->send();

		$this->assertSame($client->getResponse(), $this->response, 'Client returns response instance.');
	}
}