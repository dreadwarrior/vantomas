<?php
class Tx_Vantomas_Domain_Repository_DisqusRepository implements t3lib_Singleton {

	/**
	 *
	 * @var Tx_Vantomas_Domain_Repository_DisqusRepository
	 */
	protected $api;

	/**
	 *
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	public function injectDisqusApiService(Tx_Vantomas_Service_DisqusApiService $api) {
		$this->api = $api;
	}
	/**
	 * injects the object manager into the repository
	 *
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	public function findLatestForumPosts($forumName, $limit) {
		$posts = $this->api->listForumPosts($forumName, NULL, array('thread'), NULL, $limit);

		return $posts;
	}
}
?>