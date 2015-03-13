<?php
namespace DreadLabs\VantomasWebsite\Tests\Unit\Disqus;

use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyConfiguration;
use DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyResource;

/**
 * DISQUS API TestCase
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class ApiTest extends \PHPUnit_Framework_TestCase {

	public function testClientProxy() {
		$configuration = new DummyConfiguration();

		$client = $this->getMock('DreadLabs\\VantomasWebsite\\Tests\\Fixture\\Disqus\\DummyClient');
		$client->expects($this->once())->method('connectWith')->with('foobar');

		$resource = new DummyResource();

		$api = new \DreadLabs\VantomasWebsite\Disqus\Api(
			$configuration,
			$client,
			$resource
		);

		$api->connectWith('foobar');
	}
}