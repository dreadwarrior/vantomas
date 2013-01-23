<?php
class Tx_Vantomas_ViewHelpers_Page_LastUpdatedViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @var	tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
		$this->contentObject = $this->configurationManager->getContentObject();
	}

	/**
	 * 
	 * @param integer $storagePid
	 * @param integer $begin
	 * @return string
	 */
	public function render($storagePid, $begin) {
		$conf = array(
			'pidInList' => $storagePid,
			'orderBy' => 'lastUpdated DESC',
			'max' => '1',
			'begin' => $begin
		);

		$res = $this->contentObject->exec_getQuery('pages', $conf);

		$content = '';

		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$this->templateVariableContainer->add('lastUpdatedPage', $row);

			$content .= $this->renderChildren();

			$this->templateVariableContainer->remove('lastUpdatedPage');
		}

		return $content;
	}
}
?>
