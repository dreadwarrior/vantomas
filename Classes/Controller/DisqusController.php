<?php
class Tx_Vantomas_Controller_DisqusController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 *
	 * @var Tx_Vantomas_Domain_Repository_DisqusRepository
	 */
	protected $disqusRepository = NULL;

	public function injectDisqusRepository(Tx_Vantomas_Domain_Repository_DisqusRepository $disqusRepository) {
		$this->disqusRepository = $disqusRepository;
	}

	public function latestAction() {
		$forumName = $this->settings['forumName'];
		$limit = (integer) $this->settings['limit'];

		$comments = $this->disqusRepository->findLatestForumPosts($forumName, $limit);

		$this->view->assign('comments', $comments);
	}
}
?>