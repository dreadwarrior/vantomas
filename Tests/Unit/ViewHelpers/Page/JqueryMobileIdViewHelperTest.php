<?php


require_once(t3lib_extMgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');

class Tx_Vantomas_Tests_Unit_ViewHelpers_Page_JqueryMobileIdViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {

	/**
	 *
	 * @var Tx_Vantomas_ViewHelpers_Page_JqueryMobileIdViewHelper
	 */
	protected $viewHelper = NULL;

	public function setUp() {
		parent::setUp();

		$this->viewHelper = new Tx_Vantomas_ViewHelpers_Page_JqueryMobileIdViewHelper();
		$this->injectDependenciesIntoViewHelper($this->viewHelper);
	}

	/**
	 *
	 * @test
	 * @expectedException RuntimeException
	 * @expectedExceptionMessage Please ensure to install and load ext:realurl before using this viewhelper!
	 */
	public function throwsAnExceptionIfRealurlIsNotInstalled() {
		$this->viewHelper->initialize();

		$this->viewHelper->render();
	}

	/**
	 *
	 * @test
	 */
	public function returnsTheProperlyEncodedTitle() {
		$reflectionService = $this->getMock('Tx_Extbase_Reflection_Service', array(
			'getMethodParameters'
		));
		$reflectionService->expects($this->any())->method('getMethodParameters')->will($this->returnValue(array()));

		$this->viewHelper->injectReflectionService($reflectionService);

		$this->viewHelper->initialize();

		$argumentDefinitions = $this->viewHelper->prepareArguments();

		$title = 'This is a test!';

		$this->viewHelper->setArguments(
			array(
				'title' => $title,
				'prefix' => $argumentDefinitions['prefix']->getDefaultValue(),
			)
		);

		$this->assertEquals('jqm-this-is-a-test', $this->viewHelper->render());
	}

	/**
	 *
	 * @test
	 */
	public function returnsGermanUmlautsProperlyEncoded() {
		$reflectionService = $this->getMock('Tx_Extbase_Reflection_Service', array(
			'getMethodParameters'
		));
		$reflectionService->expects($this->any())->method('getMethodParameters')->will($this->returnValue(array()));

		$this->viewHelper->injectReflectionService($reflectionService);

		$this->viewHelper->initialize();

		$argumentDefinitions = $this->viewHelper->prepareArguments();

		$title = 'Ällebätsch und Rußpartikel%$!';

		$this->viewHelper->setArguments(
			array(
				'title' => $title,
				'prefix' => $argumentDefinitions['prefix']->getDefaultValue(),
			)
		);

		$this->assertEquals('jqm-aellebaetsch-und-russpartikel', $this->viewHelper->render());
	}
}
?>