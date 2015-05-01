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

use DreadLabs\Vantomas\Validation\Validator\NotBlankUserAgentValidator;
use DreadLabs\VantomasWebsite\ContactForm;

/**
 * TestCase for NotBlankUserAgentValidator
 */
class NotBlankUserAgentValidatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var NotBlankUserAgentValidator
	 */
	protected $sut;

	/**
	 * @var ContactForm|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $contactFormMock;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->sut = new NotBlankUserAgentValidator();
		$this->contactFormMock = $this->getMock(ContactForm::class);
	}

	/**
	 * @return void
	 */
	public function testInvalidIfUserAgentStringIsEmpty() {
		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400451338, $validationResult->getFirstError()->getCode());
	}
}
