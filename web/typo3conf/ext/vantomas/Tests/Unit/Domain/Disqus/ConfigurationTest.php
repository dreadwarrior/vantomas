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
use DreadLabs\Vantomas\Domain\Disqus\Configuration;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Disqus Configuration TestCase
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var array
	 */
	protected static $settingsFixture = array(
		'disqus' => array(
			'baseUrl' => 'http://www.example.org/',
			'apiKey' => 'foo?bar!hello.world!',
		)
	);

	/**
	 * @var ConfigurationManagerInterface|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $configurationManagerMock;

	/**
	 * @var Configuration
	 */
	protected $sut;

	public function setUp() {
		$this->configurationManagerMock = $this->getMockBuilder(ConfigurationManager::class)->setMethods(array('getConfiguration'))->getMock();
		$this->configurationManagerMock->expects($this->once())->method('getConfiguration')->with($this->equalTo('Settings'))->will($this->returnValue(self::$settingsFixture));
		$this->sut = new Configuration($this->configurationManagerMock);
	}

	public function testBaseUrlEqualsConfiguredValue() {
		$baseUrl = $this->sut->getBaseUrl();

		$this->assertSame(self::$settingsFixture['disqus']['baseUrl'], $baseUrl);
	}

	public function testApiKeyEqualsConfiguredValue() {
		$apiKey = $this->sut->getApiKey();

		$this->assertSame(self::$settingsFixture['disqus']['apiKey'], $apiKey);
	}
}
