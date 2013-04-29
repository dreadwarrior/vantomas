<?php
namespace Dreadwarrior\Vantomas\Tests\Unit\ViewHelpers\Request;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (tommy@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Fluid\Tests\Unit\ViewHelpers\BaseViewHelperTest;
use Dreadwarrior\Vantomas\ViewHelpers\Request\IsAjaxViewHelper;

/**
 * IsAjaxViewHelperTest tests the corresponding view helper
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class IsAjaxViewHelperTest extends BaseViewHelperTest {

	/**
	 *
	 * @var \Dreadwarrior\Vantomas\ViewHelpers\Request\IsAjaxViewHelper
	 */
	protected $viewHelper = NULL;

	public function setUp() {
		parent::setUp();

		$this->viewHelper = new IsAjaxViewHelper();

		$this->injectDependenciesIntoViewHelper($this->viewHelper);
		$this->viewHelper->initializeArguments();

	}

	/**
	 *
	 * @test
	 */
	public function isAlwaysPositive() {
		$this->assertTrue(TRUE, TRUE, 'This test never fails');
	}

	/**
	 *
	 * @test
	 */
	public function returnsABooleanValue() {
		$this->assertThat($this->viewHelper->render(), $this->isType('boolean'));
	}

	/**
	 *
	 * @test
	 */
	public function returnsTrueIfExpectedMatchesActualEnvironmentSetting() {
		$_SERVER = array(
			'HTTP_HOST' => 'www.example.org',
			'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
		);

		$this->viewHelper->setArguments(array(
			'expectedHost' => 'www.example.org',
			'expectedXRequestedWith' => 'XMLHttpRequest'
		));

		$this->assertTrue($this->viewHelper->render());
	}

	/**
	 *
	 * @test
	 */
	public function negateArgumentNegatesTheExpectedReturnValue() {
		$_SERVER = array(
			'HTTP_HOST' => 'www.example.org',
			'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
		);

		$this->viewHelper->setArguments(array(
			'expectedHost' => 'www.example.org',
			'expectedXRequestedWith' => 'XMLHttpRequest',
			'negate' => TRUE
		));

		$this->assertFalse($this->viewHelper->render());
	}

	/**
	 *
	 * @test
	 */
	public function returnsFalseIfExpectedDoesntMatchesActualEnvironmentSetting() {
		$_SERVER = array(
			'HTTP_HOST' => 'www.example.org'
		);

		$this->viewHelper->setArguments(array(
			'expectedHost' => 'www.example.org',
			'expectedXRequestedWith' => 'XMLHttpRequest'
		));

		$this->assertFalse($this->viewHelper->render());
	}
}
?>