<?php
namespace DreadLabs\Vantomas\Configuration\Mailer;

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

use DreadLabs\VantomasWebsite\Mailer\ConfigurationInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class ContactFormConfiguration implements ConfigurationInterface {

	/**
	 * @var array
	 */
	private $settings;

	/**
	 * @param ConfigurationManagerInterface $configurationManager
	 */
	public function __construct(
		ConfigurationManagerInterface $configurationManager
	) {
		$configuration = $configurationManager->getConfiguration(
			ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
		);
		$this->settings = $configuration['plugin.']['tx_vantomas.']['settings.']['mailer.']['ContactForm.'];
	}

	/**
	 * @return array
	 */
	public function getSenderList() {
		return $this->getAddressList($this->settings['sender.']);
	}

	/**
	 * @return array
	 */
	public function getReceiverList() {
		return $this->getAddressList($this->settings['receiver.']);
	}

	/**
	 * @param array $addresses
	 * @return array
	 */
	private function getAddressList(array $addresses) {
		$addressList = array();

		foreach ($addresses as $address) {
			$addressList[$address['mail']] = $address['name'];
		}

		return $addressList;
	}
}