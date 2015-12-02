<?php
namespace DreadLabs\Vantomas\Messaging;

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

use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Messaging\AbstractStandaloneMessage;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Provides a maintenance page message object.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class MaintenancepageMessage extends AbstractStandaloneMessage
{

    /**
     * Constructor for an Error message
     *
     * @param string $message The error message
     * @param string $title Title of the message, can be empty
     * @param int $severity Optional severity, must be either of
     * AbstractMessage::INFO or related constants
     */
    public function __construct($message = '', $title = '', $severity = AbstractMessage::ERROR)
    {
        $this->htmlTemplate = ExtensionManagementUtility::extPath(
            'vantomas',
            'Resources/Private/Templates/Page/Maintenance.html'
        );

        parent::__construct($message, $title, $severity);
    }
}
