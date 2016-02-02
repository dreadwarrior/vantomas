<?php
namespace DreadLabs\Vantomas\Domain\Sitemap;

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

use DreadLabs\VantomasWebsite\Page\Identifier;
use DreadLabs\VantomasWebsite\Page\IdentifierCollection;
use DreadLabs\VantomasWebsite\Sitemap\ConfigurationInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * TypoScript configuration impl
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Root of the TypoScript settings for this configuration impl
     *
     * @var string
     */
    private static $configurationRoot = 'sitemap';

    /**
     * The DIC ObjectManager
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Resolved setting of this configuration impl
     *
     * @var array
     */
    private $settings = [];

    /**
     * Constructor
     *
     * @param ConfigurationManagerInterface $configurationManager Application
     * ConfigurationManager
     * @param ObjectManagerInterface $objectManager DIC ObjectManager
     */
    public function __construct(
        ConfigurationManagerInterface $configurationManager,
        ObjectManagerInterface $objectManager
    ) {
        $configuration = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
        );
        $this->settings = $configuration[self::$configurationRoot];
        $this->objectManager = $objectManager;
    }
    /**
     * Returns a collection of page identifiers
     *
     * @return IdentifierCollection
     */
    public function getParentPageIdentifiers()
    {
        return $this->getIdentifierCollectionFromSetting('pids');
    }

    /**
     * Returns a page identifier collection from the given settings key
     *
     * @param string $settingKey The settings key
     *
     * @return IdentifierCollection
     */
    private function getIdentifierCollectionFromSetting($settingKey)
    {
        $collection = $this->objectManager->get(IdentifierCollection::class);

        foreach ($this->settings[$settingKey] as $pid) {
            $identifier = Identifier::fromString($pid);
            $collection->add($identifier);
        }

        return $collection;
    }

    /**
     * Returns a collection of page identifiers to exclude
     *
     * @return IdentifierCollection
     */
    public function getExcludePageIdentifiers()
    {
        return $this->getIdentifierCollectionFromSetting('excludeUids');
    }
}
