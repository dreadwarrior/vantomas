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
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * FlashMessageFactory
 *
 * Returns a FlashMessage which gets a translated message and classes prepared
 * for rendering in a zurb foundation empowered frontend context.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FlashMessageFactory implements FlashMessageFactoryInterface
{

    /**
     * DI ObjectManager
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * The extension key
     *
     * @var string
     */
    private $extensionKey;

    /**
     * The translation catalogue
     *
     * @var string
     */
    private $translationCatalogue;

    /**
     * Constructor
     *
     * @param ObjectManagerInterface $objectManager DI ObjectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Sets necessary values for the LocalizationUtility
     *
     * @param string $extensionKey The extension key
     * @param string $translationCatalogue The translation catalogue file reference
     *
     * @return void
     */
    public function configureLocalizationUtility($extensionKey, $translationCatalogue)
    {
        $this->extensionKey = trim($extensionKey);
        $this->translationCatalogue = trim($translationCatalogue);
    }

    /**
     * Creates and returns an error-level flash message
     *
     * @param string $messageKey The message key within the localization file
     *
     * @return FlashMessage
     */
    public function createError($messageKey)
    {
        return $this->create($messageKey, AbstractMessage::ERROR);
    }

    /**
     * Creates and returns an info-level flash message
     *
     * @param string $messageKey The message key within the localization file
     *
     * @return FlashMessage
     */
    public function createInfo($messageKey)
    {
        return $this->create($messageKey, AbstractMessage::INFO);
    }

    /**
     * Creates and returns a FlashMessage
     *
     * @param string $messageKey The message key within the localization file
     * @param int $severity Severity
     *
     * @return FlashMessage
     */
    private function create($messageKey, $severity = AbstractMessage::INFO)
    {
        $message = $messageKey;

        if (!(empty($this->extensionKey) || empty($this->translationCatalogue))) {
            $message = LocalizationUtility::translate(
                $this->translationCatalogue . ':' . $messageKey,
                $this->extensionKey
            );
        }

        return $this->objectManager->get(FlashMessage::class, $message, '', $severity, true);
    }
}
