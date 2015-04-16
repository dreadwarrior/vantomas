<?php
namespace DreadLabs\Vantomas\Tests\Unit\Validation\Validator;

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
use DreadLabs\Vantomas\Validation\Validator\DateTimeDeltaValidator;
use DreadLabs\VantomasWebsite\Form\Contact;

/**
 * TestCase for the DateTimeDeltaValidator
 */
class DateTimeDeltaValidatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var DateTimeDeltaValidator
	 */
	protected $sut;

	/**
	 * @var Contact|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $contactMock;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->sut = new DateTimeDeltaValidator();

		$this->contactMock = $this->getMock(Contact::class);
	}

	/**
	 * @return void
	 */
	public function testInvalidIfDateTimeDeltaIsTooLow() {
		$then = new \DateTime();

		$this->contactMock
			->expects($this->once())
			->method('getCreationDate')
			->will($this->returnValue($then));

		$validationResult = $this->sut->validate($this->contactMock->getCreationDate());

		$this->assertEquals(1400452475, $validationResult->getFirstError()->getCode());
	}

	/**
	 * @return void
	 */
	public function testInvalidIfDateTimeDeltaIsTooHigh() {
		$then = new \DateTime();
		$fiveMinutesAndFiveSeconds = new \DateInterval('PT305S');
		$then->sub($fiveMinutesAndFiveSeconds);

		$this->contactMock
			->expects($this->any())
			->method('getCreationDate')
			->will($this->returnValue($then));

		$validationResult = $this->sut->validate($this->contactMock->getCreationDate());

		$this->assertEquals(1400452604, $validationResult->getFirstError()->getCode());
	}
}