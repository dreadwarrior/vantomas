<?php
namespace DreadLabs\Vantomas\Disqus;

use DreadLabs\VantomasWebsite\Disqus\ConfigurationInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class Configuration implements ConfigurationInterface {

	/**
	 * @var string
	 */
	private $configurationRoot = 'disqus';

	/**
	 * @var array
	 */
	private $settings = array(
		'baseUrl' => '',
		'apiKey' => '',
	);

	/**
	 * @param ConfigurationManagerInterface $configurationManager
	 */
	public function __construct(ConfigurationManagerInterface $configurationManager) {
		$settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$this->settings = $settings[$this->configurationRoot];
	}

	/**
	 * @return string
	 */
	public function getBaseUrl() {
		return $this->settings['baseUrl'];
	}

	/**
	 * @return string
	 */
	public function getApiKey() {
		return $this->settings['apiKey'];
	}
}