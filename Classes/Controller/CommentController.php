<?php
class Tx_Vantomas_Controller_CommentController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 *
	 * @var Tx_Vantomas_Domain_Repository_CommentRepository
	 */
	protected $commentRepository = NULL;

	/**
	 *
	 * @param Tx_Vantomas_Domain_Repository_CommentRepository $commentRepository
	 * @return void
	 */
	public function injectCommentRepository(Tx_Vantomas_Domain_Repository_CommentRepository $commentRepository) {
		$this->commentRepository = $commentRepository;
	}

	public function latestAction() {
		$storagePid = (integer) $this->settings['storagePid'];
		$limit = (integer) $this->settings['limit'];

		$comments = $this
			->commentRepository
			->findLatest($storagePid, $limit);

		$this->view->assign('comments', $comments);
	}
}
?>