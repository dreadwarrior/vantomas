<?php
namespace DreadLabs\Vantomas\Service\Disqus;

use \DreadLabs\Vantomas\Service\Disqus\AbstractApi;

class CurlApi extends AbstractApi {

	/**
	 *
	 * @var ressource
	 */
	protected $client = NULL;

	public function loadData() {
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