<?php
namespace DreadLabs\VantomasWebsite\Twitter;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class Configuration implements ConfigurationInterface {

	/**
	 * @param ConfigurationManagerInterface $configurationManager
	 */
	public function __construct(ConfigurationManagerInterface $configurationManager) {
		$settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$this->settings = $settings[ConfigurationInterface::CONFIGURATION_ROOT];
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