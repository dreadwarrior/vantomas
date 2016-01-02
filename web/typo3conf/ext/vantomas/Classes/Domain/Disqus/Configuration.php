<?php
namespace DreadLabs\Vantomas\Domain\Disqus;

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

use DreadLabs\VantomasWebsite\Disqus\ConfigurationInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * TypoScript configuration impl
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Root of the TypoScript setup
     *
     * @var string
     */
    private $configurationRoot = 'disqus';

    /**
     * The settings for this configuration DO
     *
     * @var array
     */
    private $settings = [
        'baseUrl' => '',
        'apiKey' => '',
    ];

    /**
     * Constructor
     *
     * @param ConfigurationManagerInterface $configurationManager The application
     * ConfigurationManager
     */
    public function __construct(ConfigurationManagerInterface $configurationManager)
    {
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        $this->settings = $settings[$this->configurationRoot];
    }

    /**
     * Returns the configured baseUrl
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->settings['baseUrl'];
    }

    /**
     * Returns the configured apiKey
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->settings['apiKey'];
    }
}
