<?php
namespace DreadLabs\VantomasWebsite\Tests\Unit\Disqus;

class ConcreteResourceTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
	}

	public function testGetPathParametersWillCallAccordingSetterMethod() {
		$resource = $this->getMock(
			'DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyConcreteResource',
			array('setFoo')
		);

		$parameters = array(
			'foo' => 'bar'
		);

		$resource->expects($this->once())
			->method('setFoo')
			->with('bar');

		$resource->getPath($parameters);
	}

	public function testGetPathFlatsArrays() {
		$resource = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyConcreteResource', NULL);

		$parameters = array(
			'foo' => array(
				'is',
				'an',
				'array',
			),
		);

		$path = $resource->getPath($parameters);

		$this->assertContains('foo=is', $path);
		$this->assertContains('foo=an', $path);
		$this->assertContains('foo=array', $path);
	}
}