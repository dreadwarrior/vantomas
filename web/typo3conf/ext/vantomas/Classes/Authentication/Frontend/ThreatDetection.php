<?php
namespace DreadLabs\Vantomas\Authentication\Frontend;

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

use DreadLabs\Vantomas\Authentication\ControlInterface;
use DreadLabs\Vantomas\Authentication\ReCaptcha;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Sv\AuthenticationService;

/**
 * ThreatDetection
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ThreatDetection extends AuthenticationService
{

    /**
     * DI ObjectManager
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * The threat control impl
     *
     * @var ControlInterface
     */
    private $control;

    /**
     * Initialization and availability check of the service
     *
     * @return bool
     */
    public function init()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $secret = (string) $this->getServiceOption('secret');

        $this->control = $this->objectManager->get(
            ReCaptcha::class,
            $secret,
            GeneralUtility::_POST('g-recaptcha-response')
        );

        return true;
    }

    /**
     * Avoids call of further authentication mechanisms after threat detection
     *
     * @param array $user Data of user.
     *
     * @return int >= 200: User authenticated successfully.
     *                     No more checking is needed by other auth services.
     *             >= 100: User not authenticated; this service is not responsible.
     *                     Other auth services will be asked.
     *             > 0:    User authenticated successfully.
     *                     Other auth services will still be asked.
     *             <= 0:   Authentication failed, no more checking needed
     *                     by other auth services.
     */
    public function authUser(array $user)
    {
        $authStatus = 100;

        if ($this->control->isThreat()) {
            $authStatus = -1;
        }

        return $authStatus;
    }
}
