<?php
namespace DreadLabs\VantomasWebsite\Tests\Unit\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Api;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyConcreteClient;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyConfiguration;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyResource;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyResponse;

/**
 * DISQUS API resource operations TestCase
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class ApiResourceTest extends \PHPUnit_Framework_TestCase {

	protected $configuration = null;

	protected $client = null;

	protected $resource = null;

	public function setUp() {
		$this->configuration = new DummyConfiguration();
		$this->client = new DummyConcreteClient();
		$this->resource = new DummyResource();
	}

	public function testConfigurationSetsBaseUrlOnResource() {
		/* @var $client \PHPUnit_Framework_MockObject_MockObject|\DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyClient */
		$client = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyClient');

		/* @var $resource \PHPUnit_Framework_MockObject_MockObject|\DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyResource */
		$resource = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyResource');
		$resource->expects($this->once())->method('setBaseUrl')->with('http://example.org');

		$api = new Api(
			$this->configuration,
			$client,
			$resource
		);

		$api->execute('foo/bar.json');
	}

	public function testExecutionSetsResourceSignatureOnResource() {
		/* @var $client \PHPUnit_Framework_MockObject_MockObject|\DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyClient */
		$client = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyClient');

		/* @var $resource \PHPUnit_Framework_MockObject_MockObject|DummyResource */
		$resource = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyResource');
		$resource->expects($this->once())->method('setResourceSignature')->with('foo/bar.json');

		$api = new Api(
			$this->configuration,
			$client,
			$resource
		);

		$api->execute('foo/bar.json');
	}

	public function testApiKeyIsAddedFromConfigurationToParameters() {
		$inputParameters = array(
			'forum' => 'fooBarForum',
		);

		$expectedParameters = array(
			'forum' => 'fooBarForum',
			'api_key' => 'foo-bar-baz',
		);

		$response = new DummyResponse();

		/* @var $client \PHPUnit_Framework_MockObject_MockObject|\DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyClient */
		$client = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyClient');

		/* @var $resource \PHPUnit_Framework_MockObject_MockObject|DummyResource */
		$resource = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyResource');
		$resource->expects($this->once())->method('setParameters')->with($expectedParameters);

		$client->expects($this->once())->method('connectTo')->with($resource)->will($this->returnValue($client));
		$client->expects($this->once())->method('send')->will($this->returnValue($client));
		$client->expects($this->once())->method('disconnect')->will($this->returnValue($client));
		$client->expects($this->once())->method('getResponse')->will($this->returnValue($response));

		$api = new Api(
			$this->configuration,
			$client,
			$resource
		);

		$api->with($inputParameters);
	}
}