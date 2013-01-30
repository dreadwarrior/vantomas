<?php
class Tx_Vantomas_Controller_PageStatisticsController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 *
	 * @var Tx_Vantomas_Domain_Repository_PageRepository
	 */
	protected $pageRepository = NULL;

	/**
	 *
	 * @param Tx_Vantomas_Domain_Repository_PageRepository $pageRepository
	 * @return void
	 */
	public function injectPageRepository(Tx_Vantomas_Domain_Repository_PageRepository $pageRepository) {
		$this->pageRepository = $pageRepository;
	}

	public function mostPopularAction() {
		$storagePid = (integer) $this->settings['storagePid'];
		$limit = (integer) $this->settings['limit'];

		$pages = $this
			->pageRepository
			->findMostPopularPages($storagePid, $limit);

		$this->view->assign('pages', $pages);
	}
}
?>