<?php
namespace DreadLabs\Vantomas\Twitter;

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Thomas Juhnke (typo3@van-tomas.de)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DreadLabs\VantomasWebsite\Twitter\ConfigurationInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

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