<?php
namespace DreadLabs\Vantomas\Service\Disqus;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (tommy@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use \TYPO3\CMS\Core\SingletonInterface;

/**
 * Abstract of a concrete API client.
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
abstract class AbstractApi implements SingletonInterface {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * base url of the API service
	 *
	 * @var string
	 */
	protected $baseUrl  = 'https://disqus.com/api/3.0/';

	/**
	 *
	 * @var string
	 */
	protected $apiKey = '';

	/**
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	public function setBaseUrl($baseUrl) {
		if ('' !== trim($baseUrl)) {
			$this->baseUrl = $baseUrl;
		}
	}

	public function setApiKey($apiKey) {
		$this->apiKey = $apiKey;
	}

	public function setUrl($url) {
		$this->url = $this->replaceApiKey($url);
	}

	protected function replaceApiKey($url) {
		$replacePairs = array(
			'%apiKey%' => $this->apiKey,
		);

		return strtr($url, $replacePairs);
	}

	abstract public function loadData();

	abstract protected function createClient();

	abstract protected function sendRequest();

	abstract protected function destroyClient();
}
?>