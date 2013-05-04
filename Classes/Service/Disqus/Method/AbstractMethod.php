<?php
namespace DreadLabs\Vantomas\Service\Disqus\Method;

use \TYPO3\CMS\Core\SingletonInterface;

abstract class AbstractMethod implements SingletonInterface {

	/**
	 *
	 * @var string
	 */
	protected $api_key = '';

	public function setApi_key($apiKey) {
		$this->api_key = $apiKey;
	}

	public function getUrl(array $parameters) {
		foreach ($parameters as $parameterName => $parameterValue) {
			$parameterMethod = 'set' . ucfirst($parameterName);

			$this->$parameterMethod($parameterValue);
		}

		return $this->buildUrl();
	}

	protected function buildUrl() {
		$urlParameters = array();

		$parameters = get_object_vars($this);

		foreach ($parameters as $parameterName => $parameterValue) {
			if (TRUE === is_null($parameterValue)) {
				continue;
			}

			$urlParameters[] = $this->getUrlParameter($parameterName, $parameterValue);
		}

		return implode('&', $urlParameters);
	}

	protected function getUrlParameter($parameterName, $parameterValue) {
		$urlParameter = '';

		if (TRUE === is_scalar($parameterValue)) {
			$urlParameter = $this->getScalarUrlParameter($parameterName, $parameterValue);
		} else if (TRUE === is_array($parameterValue)) {
			$urlParameter = $this->getArrayUrlParameter($parameterName, $parameterValue);
		} else {
			throw new \Exception('The parameter type ' . gettype($parameterValue) . ' is currently not supported!', 1367354994);
		}

		return $urlParameter;
	}

	protected function getScalarUrlParameter($parameterName, $parameterValue) {
		return $parameterName . '=' . $parameterValue;
	}

	protected function getArrayUrlParameter($parameterName, $parameterValue) {
		$urlParameter = array();

		foreach ($parameterValue as $parameterValueValue) {
			$urlParameter[] = $this->getScalarUrlParameter($parameterName, $parameterValueValue);
		}

		return implode('&', $urlParameter);
	}
}
?>