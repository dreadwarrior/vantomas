<?php
namespace DreadLabs\Vantomas\Domain\Twitter;

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

use DreadLabs\VantomasWebsite\Twitter\ConfigurationInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * TypoScript configuration impl
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Configuration implements ConfigurationInterface {

	/**
	 * Configuration root of the TypoScript setup for this configuration impl
	 *
	 * @var string
	 */
	private $configurationRoot = 'twitter';

	/**
	 * Settings of this configuration impl
	 *
	 * @var array
	 */
	private $settings = array(
		'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0 Iceweasel/31.4.0',
		'bearerCacheLifetime' => 86400,
		'consumerKey' => '',
		'consumerSecret' => '',
		'bearerTokenUrl' => 'https://api.twitter.com/oauth2/token',
	);

	/**
	 * Constructor
	 *
	 * @param ConfigurationManagerInterface $configurationManager Application
	 * ConfigurationManager
	 */
	public function __construct(ConfigurationManagerInterface $configurationManager) {
		$settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$this->settings = $settings[$this->configurationRoot];
	}

	/**
	 * Returns the configured user agent
	 *
	 * @return string
	 */
	public function getUserAgent() {
		return $this->settings['userAgent'];
	}

	/**
	 * Returns the configured cache lifetim
	 *
	 * @return int
	 */
	public function getBearerCacheLifetime() {
		return $this->settings['bearerCacheLifetime'];
	}

	/**
	 * Returns the configured consumer key
	 *
	 * @return string
	 */
	public function getConsumerKey() {
		return $this->settings['consumerKey'];
	}

	/**
	 * Returns the configured consumer secret
	 *
	 * @return string
	 */
	public function getConsumerSecret() {
		return $this->settings['consumerSecret'];
	}

	/**
	 * Returns the configured bearer token url
	 *
	 * @return string
	 */
	public function getBearerTokenUrl() {
		return $this->settings['bearerTokenUrl'];
	}
}
