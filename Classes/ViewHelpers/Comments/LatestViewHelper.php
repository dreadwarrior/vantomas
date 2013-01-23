<?php
class Tx_Vantomas_ViewHelpers_Comments_LatestViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	private $table = 'tx_comments_comments';

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
	 * @param boolean $recursive
	 * @return string
	 */
	public function render($storagePid, $limit, $recursive = FALSE) {
		$conf = array(
			'pidInList' => $storagePid,
			'recursive' => (int) $recursive,
			'orderBy' => 'crdate DESC',
			'max' => $limit,
			'where' => 'approved = 1 AND deleted = 0'
		);

		$res = $this->contentObject->exec_getQuery($this->table, $conf);

		$content = '';

		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$this->templateVariableContainer->add('comment', $row);

			$page = $this->getPage($row['pid']);
			$this->templateVariableContainer->add('commentPage', $page);

			$content .= $this->renderChildren();

			$this->templateVariableContainer->remove('comment');
			$this->templateVariableContainer->remove('commentPage');
		}

		return $content;
	}

	private function getPage($pid) {
		$page = array(
			'title' => 'Page not found!',
			'subtitle' => 'Page not found!'
		);

		$statement = $GLOBALS['TYPO3_DB']->prepare_SELECTquery(
			'title, subtitle',
			'pages',
			'uid = :uid AND deleted = 0 AND hidden = 0'
		);

		$statement->execute(array(
			':uid' => $pid
		));

		if (($row = $statement->fetch()) !== FALSE) {
			$page = $row;
		}

		$statement->free();

		return $page;
	}
}
?>
