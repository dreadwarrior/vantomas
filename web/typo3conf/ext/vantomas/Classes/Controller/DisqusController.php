<?php
namespace DreadLabs\Vantomas\Controller;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Thomas Juhnke (typo3@van-tomas.de)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
	 *
	 * @param \DreadLabs\VantomasWebsite\Disqus\ApiInterface $api
	 */
	public function __construct(ApiInterface $api) {
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