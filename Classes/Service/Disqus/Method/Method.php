<?php
namespace DreadLabs\Vantomas\Service\Disqus\Method;

class Method implements MethodInterface {

	/**
	 *
	 * @var string
	 */
	protected $methodSignature;

	/**
	 *
	 * @var \TYPO3\CMS\Core\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 *
	 * @var \DreadLabs\Vantomas\Service\Disqus\Method\AbstractMethod
	 */
	protected $concreteMethod;

	/**
	 *
	 * @var string
	 */
	protected $format = '';

	public function __construct($methodSignature) {
		$this->methodSignature = $methodSignature;
	}

	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;

		$this->initializeConcreteMethod();
	}

	protected function initializeConcreteMethod() {
		list($scope, $methodAndFormat) = explode('/', $this->methodSignature);
		list($method, $this->format) = explode('.', $methodAndFormat);

		$concreteMethod = 'DreadLabs\\Vantomas\\Service\\Disqus\\Method\\' . ucfirst($scope) . '\\' . ucfirst($method);

		try {
 			$this->concreteMethod = $this->objectManager->get($concreteMethod);
 		} catch (\Exception $e) {
 			throw new \Exception('The method ' . $this->methodSignature . ' is currently not implemented!', 1367666179);
 		}
	}

	public function getUrl(array $parameters) {
		$methodUrl = $this->concreteMethod->getUrl($parameters);

		return $this->methodSignature . '?' . $methodUrl;
	}

	public function getFormat() {
		return $this->format;
	}
}
?>