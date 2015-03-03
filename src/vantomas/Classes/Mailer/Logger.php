<?php
namespace DreadLabs\Vantomas\Mailer;

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Thomas Juhnke <typo3@van-tomas.de>
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

use DreadLabs\VantomasWebsite\Mailer\LoggerInterface;
use TYPO3\CMS\Core\Log;

class Logger implements LoggerInterface {


	/**
	 * @var Log\Logger
	 */
	private $logger;

	/**
	 * @param Log\LogManager $logManager
	 */
	public function __construct(Log\LogManager $logManager) {
		$this->logger = $logManager->getLogger(__CLASS__);
	}

	/**
	 * @param string $message
	 * @param array $context
	 * @return void
	 */
	public function alert($message, array $context = array()) {
		$this->logger->alert($message, $context);
	}
}