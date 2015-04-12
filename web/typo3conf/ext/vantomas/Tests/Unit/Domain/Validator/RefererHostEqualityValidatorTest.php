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

use DreadLabs\Vantomas\Validation\Validator\RefererHostEqualityValidator;
use DreadLabs\VantomasWebsite\ContactForm;

/**
 * TestCase for the RefererHostEqualityValidator
 */
class RefererHostEqualityValidatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var RefererHostEqualityValidator
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

		$this->sut = new RefererHostEqualityValidator();

		$this->contactFormMock = $this->getMock(ContactForm::class);
	}

	/**
	 * @return void
	 */
	public function testInvalidIfRefererDoesNotMatchHost() {
		$GLOBALS['_SERVER']['HTTP_USER_AGENT'] = 'PHPUnit/' . \PHPUnit_Runner_Version::id();
		$GLOBALS['_SERVER']['HTTP_REFERER'] = 'http://example.org';
		$GLOBALS['_SERVER']['HTTP_HOST'] = 'http://foo.bar';

		$validationResult = $this->sut->validate($this->contactFormMock);

		$this->assertEquals(1400451586, $validationResult->getFirstError()->getCode());
	}
}