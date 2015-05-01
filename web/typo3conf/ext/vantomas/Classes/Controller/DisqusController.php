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

use DreadLabs\VantomasWebsite\Disqus\ApiInterface;
use DreadLabs\VantomasWebsite\Disqus\Api\Exception;
use DreadLabs\VantomasWebsite\Disqus\Response\Exception as DisqusResponseException;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * DisqusController gives access to the disqus API service
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class DisqusController extends ActionController {

	/**
	 *
	 * @var ApiInterface
	 */
	protected $api = NULL;

	/**
	 * @param \DreadLabs\VantomasWebsite\Disqus\ApiInterface $api
	 * @return void
	 */
	public function injectApi(ApiInterface $api) {
		$this->api = $api;
	}

	/**
	 * Displays the latest disqus comments
	 *
	 * @return void
	 */
	public function latestAction() {
		try {
			$parameters = array(
				'forum' => $this->settings['forumName'],
				'since' => NULL,
				'related' => array(
					'thread'
				),
				'limit' => (integer) $this->settings['limit'],
			);

			$comments = $this->api->connectWith('curl')->execute('forums/listPosts.json')->with($parameters);

			$this->view->assign('comments', $comments);
		} catch (Exception $e) {
			$this->forward('responseError', NULL, NULL, array('message' => $e->getMessage()));
		} catch (DisqusResponseException $e) {
			$this->forward('responseError', NULL, NULL, array('message' => $e->getMessage()));
		}
	}

	/**
	 * Dedicated error output action
	 *
	 * @param string $message
	 * @return void
	 */
	public function responseErrorAction($message) {
		$this->view->assign('errorMessage', $message);
	}
}
