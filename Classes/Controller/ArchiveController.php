<?php
class Tx_Vantomas_Controller_ArchiveController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 *
	 * @var Tx_Vantomas_Domain_Repository_PageRepository
	 */
	protected $pageRepository = NULL;

	public function injectPageRepository(Tx_Vantomas_Domain_Repository_PageRepository $pageRepository) {
		$this->pageRepository = $pageRepository;
	}

	/**
	 *
	 *
	 */
	public function listAction() {
		$storagePid = $this->settings['storagePid'];

		$pages = $this
			->pageRepository
			->findByStoragePidOrderedDescendingByLastUpdated($storagePid);

		$this->view->assign('pages', $pages);
	}

	/**
	 *
	 * @param string $month
	 * @param integer $year
	 * @ignorevalidation $month
	 * @ignorevalidation $year
	 */
	public function searchAction($month, $year) {
		$storagePid = $this->settings['storagePid'];

		$pages = $this
			->pageRepository
			->findByStoragePidOrderedDescendingByLastUpdatedInAGivenMonth($storagePid, (integer) $month, (integer) $year);

		$this->view->assign('pages', $pages);
	}
}
?>
