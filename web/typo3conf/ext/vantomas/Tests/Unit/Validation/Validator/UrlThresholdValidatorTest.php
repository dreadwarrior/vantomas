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

use DreadLabs\Vantomas\Validation\Validator\UrlThresholdValidator;
use DreadLabs\VantomasWebsite\Form\Contact\Message;

/**
 * TestCase for the UrlThresholdValidator
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class UrlThresholdValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * SUT
     *
     * @var UrlThresholdValidator
     */
    protected $sut;

    /**
     * Message mock
     *
     * @var Message|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $messageMock;

    /**
     * Sets up this test case
     *
     * @return void
     */
    public function setUp()
    {
        $this->sut = new UrlThresholdValidator();

        $this->messageMock = $this->getMock(Message::class);
    }

    /**
     * InvalidIfMessageContainsTooManyUrls
     *
     * @return void
     */
    public function testInvalidIfMessageContainsTooManyUrls()
    {
        $spamFixtures = [];

        for ($i = 1; $i <= 6; $i++) {
            $spamFixtures[] = file_get_contents(
                __DIR__ . '/Fixtures/ContactFormSpamFixture-00' . $i . '.txt'
            );
        }

        $this->messageMock
            ->expects($this->any())
            ->method('getMessage')
            ->will(
                call_user_func_array([$this, 'onConsecutiveCalls'], $spamFixtures)
            );

        for ($i = 1; $i <= 6; $i++) {
            $validationResult = $this->sut->validate($this->messageMock->getMessage());

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
