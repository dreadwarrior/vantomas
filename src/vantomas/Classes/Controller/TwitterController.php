<?php
namespace DreadLabs\Vantomas\Controller;

class TwitterController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 *
	 * @var \DreadLabs\Vantomas\Service\TwitterService
	 * @inject
	 */
	protected $twitterService;

	public function timelineAction() {
		$params = array(
			'screen_name' => $this->settings['screenName'],
			'count' => (integer) $this->settings['limit'],
		);

		$tweets = $this->twitterService->get('https://api.twitter.com/1.1/statuses/user_timeline.json', $params);

		$this->view->assign('tweets', $tweets);
	}

	public function searchAction() {
		$params = array(
			'q' => urlencode('#' . $this->settings['hashTag']),
			'count' => (integer) $this->settings['limit'],
		);

		$tweets = $this->twitterService->get('https://api.twitter.com/1.1/search/tweets.json', $params);

		$this->view->assign('tweets', $tweets);
	}
}