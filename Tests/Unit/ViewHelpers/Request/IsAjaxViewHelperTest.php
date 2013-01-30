<?php
require_once(t3lib_extMgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');

class Tx_Vantomas_Tests_Unit_ViewHelpers_Request_IsAjaxViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {

	/**
	 *
	 * @var Tx_Vantomas_ViewHelpers_Request_IsAjaxViewHelper
	 */
	protected $viewHelper = NULL;

	public function setUp() {
		parent::setUp();

		$this->viewHelper = new Tx_Vantomas_ViewHelpers_Request_IsAjaxViewHelper();

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