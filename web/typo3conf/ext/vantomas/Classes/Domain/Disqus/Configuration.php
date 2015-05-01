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
