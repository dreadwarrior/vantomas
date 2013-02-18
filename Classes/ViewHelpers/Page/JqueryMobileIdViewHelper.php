<?php

require_once t3lib_extMgm::extPath('realurl', 'class.tx_realurl.php');
require_once t3lib_extMgm::extPath('realurl', 'class.tx_realurl_advanced.php');

class Tx_Vantomas_ViewHelpers_Page_JqueryMobileIdViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	protected $realurlInstance;

	public function initializeArguments() {
		$this->registerArgument('title', 'string', 'The title to encode into a ID-attribute compatible string', TRUE);
		$this->registerArgument('prefix', 'string', 'The prefix for the jQuery Mobile page id', FALSE, 'jqm-');
	}

	public function initialize() {
		if (FALSE === t3lib_extMgm::isLoaded('realurl')) {
			throw new RuntimeException('Please ensure to install and load ext:realurl before using this viewhelper!', 1361207322);
		}

		$realurlInstance = t3lib_div::makeInstance('tx_realurl');

		$params = array(
			'conf' => array(
				'spaceCharacter' => '-'
			)
		);

		$this->realurlInstance = t3lib_div::makeInstance('tx_realurl_advanced');
		$this->realurlInstance->main($params, $realurlInstance);
	}

	public function render() {
		if (TYPO3_MODE === 'BE') {
			$this->simulateFrontendEnvironment();
		}

		return $this->arguments['prefix'] . $this->realurlInstance->encodeTitle($this->arguments['title']);
	}

	/**
	 * Prepares $GLOBALS['TSFE'] for Backend mode
	 * This somewhat hacky work around is currently needed because the getImgResource() function of tslib_cObj relies on those variables to be set
	 *
	 * @return void
	 */
	protected function simulateFrontendEnvironment() {
		$GLOBALS['TSFE'] = new stdClass();
		$GLOBALS['TSFE']->csConvObj = t3lib_div::makeInstance('t3lib_cs');
		$GLOBALS['TSFE']->defaultCharSet = 'utf-8';
	}
}
?>