<?php
namespace DreadLabs\VantomasWebsite\Tests\Unit\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Resource;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyConcreteResource;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyResourceResolver;

class ResourceTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|DummyResourceResolver
	 */
	protected $resourceResolver = NULL;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|DummyConcreteResource
	 */
	protected $concreteResource = NULL;

	public function setUp() {
		$this->resourceResolver = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyResourceResolver');

		$this->concreteResource = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyConcreteResource');
	}

	public function testSettingResourceSignatureInitializesConcreteResource() {
		$this->resourceResolver
			->expects($this->once())
			->method('resolve')
			->with($this->equalTo('Foo'), $this->equalTo('Bar'))
			->will($this->returnValue($this->concreteResource));

		$resource = new Resource($this->resourceResolver);
		$resource->setResourceSignature('foo/bar.json');
	}

	public function testUrlConsistsOfBaseUrlSignatureAndUrlConformParameters() {
		$this->resourceResolver
			->expects($this->once())
			->method('resolve')
			->with($this->equalTo('Foo'), $this->equalTo('Bar'))
			->will($this->returnValue($this->concreteResource));

		$parameters = array(
			'paramKey' => 'paramValue',
		);

		$this->concreteResource
			->expects($this->once())
			->method('getPath')
			->with($parameters)
			->will($this->returnValue('paramKey=paramValue'));

		$resource = new Resource($this->resourceResolver);
		$resource->setBaseUrl('http://www.example.org/');
		$resource->setResourceSignature('foo/bar.json');
		$resource->setParameters($parameters);

		$resourceUrl = $resource->getUrl();

		$this->assertSame($resourceUrl, 'http://www.example.org/foo/bar.json?paramKey=paramValue');
	}

	public function testFormatCompliesWithLastPartOfResourceSignature() {
		$this->resourceResolver
			->expects($this->once())
			->method('resolve')
			->with($this->equalTo('Foo'), $this->equalTo('Bar'))
			->will($this->returnValue($this->concreteResource));

		$resource = new Resource($this->resourceResolver);
		$resource->setResourceSignature('foo/bar.json');

		$format = $resource->getFormat();

		$this->assertSame($format, 'json');
	}
}