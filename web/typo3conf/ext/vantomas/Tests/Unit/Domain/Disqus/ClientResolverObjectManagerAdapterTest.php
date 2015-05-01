<?php
namespace DreadLabs\Vantomas\Tests\Unit\Domain\Disqus;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use DreadLabs\Vantomas\Domain\Disqus\ClientResolver\ObjectManagerAdapter;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * ClientResolverObjectManagerAdapterTest
 */
class ClientResolverObjectManagerAdapterTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $objectManagerMock;

	/**
	 * @var ObjectManagerAdapter
	 */
	protected $sut;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->objectManagerMock = $this->getMockBuilder(ObjectManager::class)->disableOriginalConstructor()->getMock();
		$this->sut = new ObjectManagerAdapter($this->objectManagerMock);
	}

	/**
	 * @return void
	 */
	public function testResolverUsesObjectManagerToRetrieveConcreteImplementation() {
		$this
			->objectManagerMock
			->expects($this->once())
			->method('get')
			->with($this->equalTo('DreadLabs\\VantomasWebsite\\Disqus\\Client\\FooBarClient'));

		$this->sut->resolve('foo_bar_client');
	}
}
