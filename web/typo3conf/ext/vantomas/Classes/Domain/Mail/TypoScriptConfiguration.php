<?php
namespace DreadLabs\Vantomas\Domain\Mail;

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

use DreadLabs\VantomasWebsite\Mail\ConfigurationInterface;
use DreadLabs\VantomasWebsite\Mail\ConveyableInterface;
use DreadLabs\VantomasWebsite\Mail\Message\ViewInterface;
use DreadLabs\VantomasWebsite\Mail\MessageInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * TypoScript configuration impl for mail
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TypoScriptConfiguration implements ConfigurationInterface {

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
		$this->settings = $configuration['plugin.']['tx_vantomas.']['settings.']['mail.'];
	}

	/**
	 * @param ConveyableInterface $conveyable
	 * @return void
	 */
	public function initializeFor(ConveyableInterface $conveyable) {
		$this->settings = $this->settings[get_class($conveyable) . '.'];
	}

	/**
	 * @param ViewInterface $view
	 * @return void
	 */
	public function configureView(ViewInterface $view) {
		$view->setTemplate($this->settings['template']);
	}

	/**
	 * @param MessageInterface $message
	 * @return void
	 */
	public function configureMessage(MessageInterface $message) {
		$message->setSender($this->getAddressList($this->settings['sender.']));
		$message->setReceiver($this->getAddressList($this->settings['receiver.']));
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
