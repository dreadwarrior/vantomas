<?php
namespace DreadLabs\VantomasWebsite\Disqus\Resource;

abstract class AbstractResource {

	/**
	 * holds the API key
	 *
	 * @var string
	 */
	protected $api_key = '';

	/**
	 * sets the API key
	 *
	 * @param string $apiKey
	 * @return void
	 */
	public function setApi_key($apiKey) {
		$this->api_key = $apiKey;
	}

	/**
	 * returns the resource path which is usable by a client
	 *
	 * @param array $parameters
	 * @return string A API query string
	 */
	public function getPath(array $parameters) {
		foreach ($parameters as $parameterName => $parameterValue) {
			$parameterMethod = 'set' . ucfirst($parameterName);

			$this->$parameterMethod($parameterValue);
		}

		return $this->buildPath();
	}

	/**
	 * builds a API query string path
	 *
	 * @return string
	 */
	protected function buildPath() {
		$urlParameters = array();

		$parameters = get_object_vars($this);

		foreach ($parameters as $parameterName => $parameterValue) {
			if (true === is_null($parameterValue)) {
				continue;
			}

			$urlParameters[] = $this->getPathPartForParameter($parameterName, $parameterValue);
		}

		return implode('&', $urlParameters);
	}

	protected function getPathPartForParameter($parameterName, $parameterValue) {
		try {
			$pathPart = $this->getPathParameter($parameterName, $parameterValue);
		} catch (\Exception $e) {
			$pathPart = '';
		}

		return $pathPart;
	}

	/**
	 * gets a parameter/value pair for usage in a URL query string
	 *
	 * @param string $parameterName
	 * @param string $parameterValue
	 * @return string
	 * @throws \Exception
	 */
	protected function getPathParameter($parameterName, $parameterValue) {
		if (true === is_scalar($parameterValue)) {
			$urlParameter = $this->getScalarPathParameter($parameterName, $parameterValue);
		} else if (true === is_array($parameterValue)) {
			$urlParameter = $this->getArrayPathParameter($parameterName, $parameterValue);
		} else {
			throw new \Exception('The setting of parameter ' . $parameterName . ' (' . gettype($parameterValue) . ') is currently not supported!', 1367354994);
		}

		return $urlParameter;
	}

	/**
	 * builds a scalar parameter/value pair
	 *
	 * @param string $parameterName
	 * @param string $parameterValue
	 * @return string
	 */
	protected function getScalarPathParameter($parameterName, $parameterValue) {
		return $parameterName . '=' . $parameterValue;
	}

	/**
	 * iterates over an array parameter value
	 *
	 * @param string $parameterName
	 * @param array $parameterValue
	 * @return string
	 */
	protected function getArrayPathParameter($parameterName, array $parameterValue) {
		$urlParameter = array();

		foreach ($parameterValue as $parameterValueValue) {
			$urlParameter[] = $this->getPathParameter($parameterName, $parameterValueValue);
		}

		return implode('&', $urlParameter);
	}
}