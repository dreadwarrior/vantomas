<?php
namespace DreadLabs\Vantomas\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use DreadLabs\VantomasWebsite\Twitter\ApiInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Provides twitter related output actions
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TwitterController extends ActionController {

	/**
	 * @var ApiInterface
	 */
	protected $api;

	/**
	 * @param \DreadLabs\VantomasWebsite\Twitter\ApiInterface $api
	 * @return void
	 */
	public function injectApi(ApiInterface $api) {
		$this->api = $api;
	}

	/**
	 * Displays a list of tweets from a users timeline
	 *
	 * @return void
	 */
	public function timelineAction() {
		$this->api->addParameter('screen_name', $this->settings['screenName']);
		$this->api->addParameter('count', (integer) $this->settings['limit']);

		$tweets = $this->api->getTimeline();

		$this->view->assign('tweets', $tweets);
	}

	/**
	 * Displays a list of tweets matching a given hashtag
	 *
	 * @return void
	 */
	public function searchAction() {
		$this->api->addParameter('q', urlencode('#' . $this->settings['hashTag']));
		$this->api->addParameter('count', (integer) $this->settings['limit']);

		$tweets = $this->api->getSearchResult();

		$this->view->assign('tweets', $tweets);
	}
}
