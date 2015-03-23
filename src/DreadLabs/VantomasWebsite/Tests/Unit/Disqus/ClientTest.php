<?php
namespace DreadLabs\VantomasWebsite\Tests\Unit\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Client;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyClient;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyResource;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyResponse;

class ClientTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|\DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyClientResolver
	 */
	protected $clientResolver = NULL;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|DummyClient
	 */
	protected $concreteClient = NULL;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|DummyResource
	 */
	protected $resource = NULL;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|DummyResponse
	 */
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

		$client = new Client(
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

		$client = new Client(
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

		$client = new Client(
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

		$client = new Client($this->clientResolver);

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

		$client = new Client($this->clientResolver);

		$client->connectWith('dummy');
		$client->send();

		$this->assertSame($client->getResponse(), $this->response, 'Client returns response instance.');
	}
}