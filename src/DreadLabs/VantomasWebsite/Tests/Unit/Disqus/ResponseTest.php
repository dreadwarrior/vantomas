<?php
namespace DreadLabs\VantomasWebsite\Tests\Unit\Disqus;

class ResponseTest extends \PHPUnit_Framework_TestCase {

	protected $responseResolver = NULL;

	protected $concreteResponse = NULL;

	public function setUp() {
		$this->responseResolver = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyResponseResolver');

		$this->concreteResponse = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyResponse');
	}

	public function testSetFormatInitializesConcreteResponseImplementation() {

		$this->responseResolver
			->expects($this->once())
			->method('resolve')
			->with($this->equalTo('dummy'))
			->will($this->returnValue($this->concreteResponse));

		$response = new \DreadLabs\VantomasWebsite\Disqus\Response($this->responseResolver);
		$response->setFormat('dummy');
	}

	public function testSetContentProxiesConcreteResponseImplementation() {

		$this->responseResolver
			->expects($this->once())
			->method('resolve')
			->will($this->returnValue($this->concreteResponse));

		$this->concreteResponse
			->expects($this->once())
			->method('setContent')
			->with('foobar');

		$response = new \DreadLabs\VantomasWebsite\Disqus\Response($this->responseResolver);
		$response->setFormat('dummy');
		$response->setContent('foobar');
	}
}