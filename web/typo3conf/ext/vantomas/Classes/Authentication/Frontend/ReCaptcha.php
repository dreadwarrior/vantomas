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

use DreadLabs\VantomasWebsite\ThreatDefense;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Sv\AuthenticationService;

/**
 * ReCaptcha
 *
 * Uses the Google ReCaptcha Service in order to determine
 * if the user should be authenticated by any other following
 * authentication service.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ReCaptcha extends AuthenticationService
{

    /**
     * @const string
     */
    const EXTENSION_KEY = 'vantomas';

    /**
     * >= 200: User authenticated successfully.
     *
     * No more checking is needed by other auth services.
     *
     * @const int
     */
    const SUCCESS_END = 200;

    /**
     * >= 100: User not authenticated; this service is not responsible.
     *
     * Other auth services will be asked.
     *
     * @const int
     */
    const NOT_RESPONSIBLE = 100;

    /**
     * > 0: User authenticated successfully.
     *
     * Other auth services will still be asked.
     *
     * @const int
     */
    const SUCCESS_NEXT = 1;

    /**
     * <= 0: Authentication failed, no more checking needed by other auth services.
     *
     * @const int
     */
    const FAILED = 0;

    /**
     * @var array
     */
    private static $subTypes = ['authUserFE'];

    /**
     * Priority
     *
     * Must be higher than:
     * - \TYPO3\CMS\Sv\AuthenticationService (50)
     * - rsaauth (60)
     * - saltedpasswords (70)
     *
     * @var int
     */
    private static $priority = 90;

    /**
     * DI ObjectManager
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * The threat control impl
     *
     * @var ThreatDefense\ControlInterface
     */
    private $control;

    public static function register()
    {
        ExtensionManagementUtility::addService(
            self::EXTENSION_KEY,
            'auth',
            __CLASS__,
            [
                'title' => 'Frontend login threat detection',
                'description' => 'Detects threats on the frontend login',
                'subtype' => implode(',', self::$subTypes),
                'available' => true,
                'priority' => self::$priority,
                'quality' => 50,
                'os' => '',
                'exec' => '',
                'className' => __CLASS__,
            ]
        );
    }

    /**
     * Injects the object manager
     *
     * @param ObjectManagerInterface|null $objectManager
     *
     * @return void
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager = null)
    {
        if (is_null($objectManager)) {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        }

        $this->objectManager = $objectManager;
    }

    /**
     * Initializes the Authentication service
     *
     * @return void
     */
    public function initializeObject()
    {
        $secret = (string) $this->getServiceOption('secret');

        $this->control = $this->objectManager->get(
            ThreatDefense\ReCaptcha::class,
            $secret
        );
    }

    /**
     * Initialization and availability check of the service
     *
     * @return bool
     */
    public function init()
    {
        try {
            $this->injectObjectManager($this->objectManager);
            $this->initializeObject();

            return true;
        } catch (\Exception $exc) {
            array_push($this->error, $exc->getMessage());

            return false;
        }
    }

    /**
     * Avoids call of further authentication mechanisms after threat detection
     *
     * @param array $user Data of user.
     *
     * @return int See class constants for more information
     */
    public function authUser(array $user)
    {
        try {
            $data = ThreatDefense\ReCaptchaResponse::fromString(
                GeneralUtility::_POST('g-recaptcha-response')
            );

            if ($this->control->isThreat($data)) {
                return self::FAILED;
            }

            return self::NOT_RESPONSIBLE;
        } catch (\InvalidArgumentException $exc) {
            array_push($this->error, $exc->getMessage());

            return self::FAILED;
        }
    }
}
