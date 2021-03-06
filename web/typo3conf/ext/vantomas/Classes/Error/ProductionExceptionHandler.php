<?php
namespace DreadLabs\Vantomas\Error;

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

use DreadLabs\AppMigration\Exception\MigrationException;
use DreadLabs\Vantomas\Messaging\ErrorpageMessage;
use DreadLabs\Vantomas\Messaging\MaintenancepageMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provides a site-specific product exception handler.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ProductionExceptionHandler extends \TYPO3\CMS\Core\Error\ProductionExceptionHandler
{

    /**
     * Echoes an exception for the web.
     *
     * @param \Exception|\Throwable $exception The exception
     *
     * @return void
     */
    public function echoExceptionWeb($exception)
    {
        $this->sendStatusHeaders($exception);
        $this->writeLogEntries($exception, self::CONTEXT_WEB);

        $errorPage = ErrorpageMessage::class;

        if ($exception instanceof MigrationException) {
            $errorPage = MaintenancepageMessage::class;
        }

        $messageObj = GeneralUtility::makeInstance(
            $errorPage,
            $this->getMessage($exception),
            $this->getTitle($exception)
        );

        $messageObj->output();
    }
}
