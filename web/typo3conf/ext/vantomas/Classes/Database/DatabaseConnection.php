<?php
namespace DreadLabs\Vantomas\Database;

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

use DreadLabs\VantomasWebsite\Migration\Exception\MigrationException;
use DreadLabs\VantomasWebsite\Migration\MediatorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * DatabaseConnection
 *
 * Slim wrapper around the TYPO3.CMS Core's DatabaseConnection class in order
 * to perform migration during application runtime.
 *
 * Note, that this class is *NOT* loaded / registered if ext:dbal is active.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class DatabaseConnection extends \TYPO3\CMS\Core\Database\DatabaseConnection {

	/**
	 * ObjectManager
	 *
	 * @var ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * Mediator
	 *
	 * @var MediatorInterface
	 */
	private $mediator;

	/**
	 * Initializes the DatabaseConnection
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		$this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		$this->mediator = $this->objectManager->get(MediatorInterface::class);
	}

	/**
	 * Open a (persistent) connection to a MySQL server
	 *
	 * @return bool|void
	 *
	 * @throws \RuntimeException Thrown in parent if php ext mysqli is not loaded.
	 */
	public function sql_pconnect() {
		$link = parent::sql_pconnect();

		try {
			$this->mediator->negotiate();
		} catch (MigrationException $exc) {
			throw new \RuntimeException('Something went wrong during migration.', 1438877473, $exc);
		}

		return $link;
	}
}
