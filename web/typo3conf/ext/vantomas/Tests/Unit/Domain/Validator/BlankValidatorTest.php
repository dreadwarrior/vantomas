<?php
namespace DreadLabs\Vantomas\Unit\Domain\Validator;

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

use DreadLabs\Vantomas\Validation\Validator\BlankValidator;
use DreadLabs\VantomasWebsite\Form\Contact\Person;

/**
 * TestCase for the BlankValidator
 */
class BlankValidatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var BlankValidator
	 */
	protected $sut;

	/**
	 * @var Person|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $personMock;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->sut = new BlankValidator();

		$this->personMock = $this->getMock(Person::class);
	}

	/**
	 * @return void
	 */
	public function testInvalidIfHoneypotFieldIsNotEmpty() {
		$this->personMock
			->expects($this->once())
			->method('getCity')
			->will($this->returnValue('Berlin'));

		$validationResult = $this->sut->validate($this->personMock->getCity());

		$this->assertEquals(1400452039, $validationResult->getFirstError()->getCode());
	}
}