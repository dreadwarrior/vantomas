<?php
namespace DreadLabs\Vantomas\Controller\SecretSanta;

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

use DreadLabs\Vantomas\Messaging\FlashMessageFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * AbstractController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
abstract class AbstractController extends ActionController {

	/**
	 * FlashMessage factory
	 *
	 * @var FlashMessageFactory
	 */
	protected $flashMessageFactory;

	/**
	 * Initializes the view
	 *
	 * @return void
	 */
	public function initializeView() {
		$usersStoragePageId = (int) $this->configurationManager->getContentObject()->data['pages'];
		$this->view->assign('usersStoragePageId', $usersStoragePageId);

		$this->flashMessageFactory = $this->objectManager->get(
			FlashMessageFactory::class,
			'LLL:EXT:vantomas/Resources/Private/Language/SecretSanta/locallang.xlf'
		);
	}
}
