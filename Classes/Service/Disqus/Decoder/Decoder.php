<?php
namespace DreadLabs\Vantomas\Service\Disqus\Decoder;

class Decoder implements DecoderInterface {

	/**
	 *
	 * @var \DreadLabs\Vantomas\Service\Disqus\Method\MethodInterface
	 */
	protected $apiMethod = NULL;

	/**
	 *
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 *
	 * @var \DreadLabs\Vantomas\Service\Disqus\Decoder\AbstractDecoder
	 */
	protected $concreteDecoder;

	public function __construct(\DreadLabs\Vantomas\Service\Disqus\Method\MethodInterface $apiMethod) {
		$this->apiMethod = $apiMethod;
	}

	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;

		$this->initializeConcreteDecoder();
	}

	protected function initializeConcreteDecoder() {
		$this->concreteDecoder = $this->objectManager->get('DreadLabs\\Vantomas\\Service\\Disqus\\Decoder\\' . ucfirst($this->apiMethod->getFormat()) . 'Decoder');
	}

	public function decode($data) {
		return $this->concreteDecoder->decode($data);
	}
}
?>