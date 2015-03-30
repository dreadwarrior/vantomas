<?php
namespace DreadLabs\Vantomas\Tests\Unit\Domain\Validator;

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

use DreadLabs\Vantomas\Validation\Validator\ContactFormAntiSpamValidator;
use DreadLabs\VantomasWebsite\ContactForm;
use DreadLabs\VantomasWebsite\ContactForm\Message;
use DreadLabs\VantomasWebsite\ContactForm\Person;

/**
 * Tests the ContactForm DO validator
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ContactFormValidatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var ContactFormAntiSpamValidator
	 */
	protected $sut;

	/**
	 * @var ContactForm|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $contactFormMock;

	/**
	 * @var Person|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $personMock;

	/**
	 * @var Message|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $messageMock;

	/**
	 * {@inheritdoc}
	 * @return void
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

		$this->sut = new ContactFormAntiSpamValidator();
		$this->contactFormMock = $this->getMock(ContactForm::class);
		$this->personMock = $this->getMock(Person::class);
		$this->messageMock = $this->getMock(Message::class);
	}

	/**
	 * @return void
	 */
	public function testValidationFailsIfUserAgentStringIsEmpty() {
		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400451338, $validationResult->getFirstError()->getCode());
	}

	/**
	 * @return void
	 */
	public function testValidationFailsIfRefererDoesNotMatchHost() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://foo.bar';

		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400451586, $validationResult->getFirstError()->getCode());
	}

	/**
	 * @return void
	 */
	public function testValidationFailsIfHoneypotFieldIsNotEmpty() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://example.org';

		$this->contactFormMock
			->expects($this->once())
			->method('getPerson')
			->will($this->returnValue($this->personMock));

		$this->personMock
			->expects($this->once())
			->method('getCity')
			->will($this->returnValue('Berlin'));

		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400452039, $validationResult->getFirstError()->getCode());
	}

	/**
	 * @return void
	 */
	public function testValidationFailsIfCreationDateDeltaIsTooLow() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://example.org';

		$then = new \DateTime();
// 		$fifteenSeconds = new \DateInterval('PT15S');
// 		$now->sub($fifteenSeconds);

		$this->contactFormMock
			->expects($this->once())
			->method('getPerson')
			->will($this->returnValue($this->personMock));

		$this->personMock
			->expects($this->once())
			->method('getCity')
			->will($this->returnValue(''));

		$this->contactFormMock
			->expects($this->once())
			->method('getCreationDate')
			->will($this->returnValue($then));

		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400452475, $validationResult->getFirstError()->getCode());
	}

	/**
	 * @return void
	 */
	public function testValidationFailsIfCreationDateDeltaIsTooHigh() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://example.org';

		$then = new \DateTime();
		$fiveMinutesAndFiveSeconds = new \DateInterval('PT305S');
		$then->sub($fiveMinutesAndFiveSeconds);

		$this->contactFormMock
			->expects($this->once())
			->method('getPerson')
			->will($this->returnValue($this->personMock));

		$this->personMock
			->expects($this->once())
			->method('getCity')
			->will($this->returnValue(''));

		$this->contactFormMock
			->expects($this->any())
			->method('getCreationDate')
			->will($this->returnValue($then));

		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400452604, $validationResult->getFirstError()->getCode());
	}

	/**
	 * @return void
	 */
	public function testValidationFailsIfMessageContainsTooManyUrls() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://example.org';

		$then = new \DateTime();
		$oneMinute = new \DateInterval('PT60S');
		$then->sub($oneMinute);

		$this->contactFormMock
			->expects($this->any())
			->method('getPerson')
			->will($this->returnValue($this->personMock));

		$this->personMock
			->expects($this->any())
			->method('getCity')
			->will($this->returnValue(''));

		$this->contactFormMock
			->expects($this->any())
			->method('getCreationDate')
			->will($this->returnValue($then));

		$spamFixtures = array();

		for ($i = 1; $i <= 6; $i++) {
			$spamFixtures[] = file_get_contents(
				__DIR__ . '/Fixtures/ContactFormSpamFixture-00' . $i . '.txt'
			);
		}

		$this->contactFormMock
			->expects($this->any())
			->method('getMessage')
			->will($this->returnValue($this->messageMock));

		$this->messageMock
			->expects($this->any())
			->method('getMessage')
			->will(
				call_user_func_array(array($this, 'onConsecutiveCalls'), $spamFixtures)
			);

		for ($i = 1; $i <= 6; $i++) {
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