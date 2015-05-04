<?php
namespace DreadLabs\Vantomas\Domain\Mail;

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

use DreadLabs\VantomasWebsite\Mail\LoggerInterface;
use TYPO3\CMS\Core\Log;

/**
 * Logger bridge to the TYPO3.CMS logging system
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Logger implements LoggerInterface {

	/**
	 * Logger impl
	 *
	 * @var Log\Logger
	 */
	private $logger;

	/**
	 * Constructor
	 *
	 * @param Log\LogManager $logManager Application log manager
	 */
	public function __construct(Log\LogManager $logManager) {
		$this->logger = $logManager->getLogger(__CLASS__);
	}

	/**
	 * Logs alert-leveled events
	 *
	 * @param string $message Log message
	 * @param array $context Context data
	 *
	 * @return void
	 */
	public function alert($message, array $context = array()) {
		$this->logger->alert($message, $context);
	}
}
