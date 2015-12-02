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
use DreadLabs\VantomasWebsite\Form\Contact;

/**
 * TestCase for NotBlankUserAgentValidator
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class NotBlankUserAgentValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * SUT
     *
     * @var NotBlankUserAgentValidator
     */
    protected $sut;

    /**
     * Contactmock
     *
     * @var Contact|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $contactMock;

    /**
     * Sets up this test case
     *
     * @return void
     */
    public function setUp()
    {
        $this->sut = new NotBlankUserAgentValidator();
        $this->contactMock = $this->getMock(Contact::class);
    }

    /**
     * InvalidIfUserAgentStringIsEmpty
     *
     * @return void
     */
    public function testInvalidIfUserAgentStringIsEmpty()
    {
        $validationResult = $this->sut->validate($this->contactMock);

        $this->assertEquals(1400451338, $validationResult->getFirstError()->getCode());
    }
}
