<?php
namespace DreadLabs\Vantomas\Controller;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Thomas Juhnke <typo3@van-tomas.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\Vantomas\Service\TwitterService;

/**
 * Provides twitter related output actions
 *
 * @package \DreadLabs\Vantomas\Controller
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class TwitterController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 *
	 * @var \DreadLabs\Vantomas\Service\TwitterService
	 */
	protected $twitterService;

	/**
	 * Injects the twitter service
	 *
	 * @param TwitterService $twitterService
	 * @return void
	 */
	public function injectTwitterService(TwitterService $twitterService) {
		$this->twitterService = $twitterService;
	}

	/**
	 * Displays a list of tweets from a users timeline
	 *
	 * @return void
	 */
	public function timelineAction() {
		$params = array(
			'screen_name' => $this->settings['screenName'],
			'count' => (integer) $this->settings['limit'],
		);

		$tweets = $this->twitterService->get('https://api.twitter.com/1.1/statuses/user_timeline.json', $params);

		$this->view->assign('tweets', $tweets);
	}

	/**
	 * Displays a list of tweets matching a given hashtag
	 *
	 * @return void
	 */
	public function searchAction() {
		$params = array(
			'q' => urlencode('#' . $this->settings['hashTag']),
			'count' => (integer) $this->settings['limit'],
		);

		$tweets = $this->twitterService->get('https://api.twitter.com/1.1/search/tweets.json', $params);

		$this->view->assign('tweets', $tweets);
	}
}