<?php
class Tx_Vantomas_ViewHelpers_Page_MostPopularViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

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
	 * @param integer $limit
	 * @return string
	 */
	public function render($storagePid, $limit) {
		$conf = array(
			'pidInList' => $storagePid,
			// orderBy according to visits field from cs_counter_plus table
			'orderBy' => 'tx_cscounterplus_info.visits DESC',
			'max' => $limit,
			// join with cs_counter_plus table
			'join' => 'tx_cscounterplus_info ON pages.uid = tx_cscounterplus_info.cid'
		);

		$res = $this->contentObject->exec_getQuery('pages', $conf);

		$content = '';

		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$this->templateVariableContainer->add('popularPage', $row);

			$content .= $this->renderChildren();

			$this->templateVariableContainer->remove('popularPage');
		}

		return $content;
	}
}
?>
