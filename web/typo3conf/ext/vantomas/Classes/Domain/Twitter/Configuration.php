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
	 * @var string
	 */
	private $configurationRoot = 'twitter';

	/**
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
	 * @param ConfigurationManagerInterface $configurationManager
	 */
	public function __construct(ConfigurationManagerInterface $configurationManager) {
		$settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$this->settings = $settings[$this->configurationRoot];
	}

	public function getUserAgent() {
		return $this->settings['userAgent'];
	}

	public function getBearerCacheLifetime() {
		return $this->settings['bearerCacheLifetime'];
	}

	public function getConsumerKey() {
		return $this->settings['consumerKey'];
	}

	public function getConsumerSecret() {
		return $this->settings['consumerSecret'];
	}

	public function getBearerTokenUrl() {
		return $this->settings['bearerTokenUrl'];
	}
}