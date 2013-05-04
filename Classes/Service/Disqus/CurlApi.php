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

use \DreadLabs\Vantomas\Service\Disqus\AbstractApi;

/**
 * cURL HTTP API implementation.
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class CurlApi extends AbstractApi {

	/**
	 *
	 * @var ressource
	 */
	protected $client = NULL;

	public function getData() {
		try {
			$this->createClient();

			$result = $this->sendRequest();

			$this->destroyClient();
		} catch (\Exception $e) {
			$result = json_encode(array(
				'error' => $e->getMessage()
			));
		}

		return $result;
	}

	protected function createClient() {
		$this->client = curl_init();

		if (FALSE === $this->client) {
			throw new \Exception('Unable to create a new cURL handle', 1367315078);
		}

		curl_setopt($this->client, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->client, CURLOPT_URL, $this->baseUrl . $this->url);
		curl_setopt($this->client, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->client, CURLOPT_MAXREDIRS, 5);
	}

	protected function sendRequest() {
		$result = curl_exec($this->client);

		if (FALSE === $result) {
			$errorCode = curl_errno($this->client);
			$errorMessage = curl_error($this->client);

			$msg = sprintf('An error occured while querying the disqus API. Error: %s (%s)', $errorMessage, $errorCode);

			throw new \Exception($msg, 1367314822);
		}

		return $result;
	}

	protected function destroyClient() {
		curl_close($this->client);
	}
}
?>