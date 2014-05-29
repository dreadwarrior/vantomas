<?php
namespace DreadLabs\Vantomas\Tests\Unit\Domain\Validator;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Thomas Juhnke <typo3@van-tomas.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\Vantomas\Domain\Validator\ContactFormValidator;
use DreadLabs\Vantomas\Domain\Model\ContactForm;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Tests the ContactForm DO validator
 *
 * @package \DreadLabs\Vantomas\Tests\Unit\Domain\Validator
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class ContactFormValidatorTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 *
	 * @var ContactFormValidator
	 */
	protected $sut;

	/**
	 *
	 * @var ContactForm
	 */
	protected $contactFormMock;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp() {
		$GLOBALS['TYPO3_CONF_VARS'] = array(
			'SYS' => array(
				'reverseProxyIP' => '',
			),
		);
		$GLOBALS['_SERVER']['REMOTE_ADDR'] = '127.0.0.1';
		if (!defined('TYPO3_REQUESTTYPE_CLI')) {
			define('TYPO3_REQUESTTYPE_CLI', 'UnitTest');
		}
		if (!defined('TYPO3_REQUESTTYPE')) {
			define('TYPO3_REQUESTTYPE', 'UnitTest');
		}
		if (!defined('TYPO3_REQUESTTYPE_INSTALL')) {
			define('TYPO3_REQUESTTYPE_INSTALL', 'UnitTest');
		}

		$this->sut = new ContactFormValidator();
		$this->contactFormMock = $this->getMock(
			'DreadLabs\\Vantomas\\Domain\\Model\\ContactForm'
		);
	}

	/**
	 *
	 * @test
	 */
	public function validationFailsIfUserAgentStringIsEmpty() {
		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400451338, $validationResult->getFirstError()->getCode());
	}

	/**
	 *
	 * @test
	 */
	public function validationFailsIfRefererDoesNotMatchHost() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://foo.bar';

		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400451586, $validationResult->getFirstError()->getCode());
	}

	/**
	 *
	 * @test
	 */
	public function validationFailsIfHoneypotFieldIsNotEmpty() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://example.org';

		$this->contactFormMock
			->expects($this->once())
			->method('getCity')
			->will($this->returnValue('Berlin'));

		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400452039, $validationResult->getFirstError()->getCode());
	}

	/**
	 *
	 * @test
	 */
	public function validationFailsIfCreationDateDeltaIsTooLow() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://example.org';

		$then = new \DateTime();
// 		$fifteenSeconds = new \DateInterval('PT15S');
// 		$now->sub($fifteenSeconds);

		$this->contactFormMock
			->expects($this->once())
			->method('getCreationDate')
			->will($this->returnValue($then));

		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400452475, $validationResult->getFirstError()->getCode());
	}

	/**
	 *
	 * @test
	 */
	public function validationFailsIfCreationDateDeltaIsTooHigh() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://example.org';

		$then = new \DateTime();
		$fiveMinutesAndFiveSeconds = new \DateInterval('PT305S');
		$then->sub($fiveMinutesAndFiveSeconds);

		$this->contactFormMock
			->expects($this->any())
			->method('getCreationDate')
			->will($this->returnValue($then));

		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400452604, $validationResult->getFirstError()->getCode());
	}

	/**
	 *
	 * @test
	 */
	public function validationFailsIfMessageContainsTooManyUrls() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://example.org';

		$then = new \DateTime();
		$oneMinute = new \DateInterval('PT60S');
		$then->sub($oneMinute);

		$this->contactFormMock
			->expects($this->any())
			->method('getCreationDate')
			->will($this->returnValue($then));

		for ($i = 1; $i <= 5; $i++) {
			$spamFixtures[] = file_get_contents(
				__DIR__ . '/Fixtures/ContactFormSpamFixture-00' . $i . '.txt'
			);
		}

		$this->contactFormMock
			->expects($this->any())
			->method('getMessage')
			->will(
				//$this->onConsecutiveCalls($spamFixtures)
				call_user_func_array(array($this, 'onConsecutiveCalls'), $spamFixtures)
			);

		for ($i = 1; $i <= 5; $i++) {
			$validationResult = $this->sut->validate($this->contactFormMock);

			if ($i === 3) {
				$this->assertFalse(
					$validationResult->hasErrors(),
					'The third fixture is - technically - no spam.'
				);
			} else {
				$this->assertTrue(
					$validationResult->hasErrors(),
					'Fixture #' . $i . ' was successfully identified as spam.'
				);
				$this->assertEquals(1400453056, $validationResult->getFirstError()->getCode());
			}
		}
	}
}
?>