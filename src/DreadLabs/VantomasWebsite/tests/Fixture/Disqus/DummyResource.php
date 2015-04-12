<?php
namespace DreadLabs\VantomasWebsite\Tests\Fixture\Disqus;

use DreadLabs\VantomasWebsite\Disqus\ResourceInterface;

class DummyResource implements ResourceInterface {

	/**
	 * sets the base url for the resource
	 *
	 * @param string $baseUrl
	 * @return void
	 */
	public function setBaseUrl($baseUrl) {
		// TODO: Implement setBaseUrl() method.
	}

	/**
	 * sets the resource signature and initiates the concrete resource implementation initialization
	 *
	 * @param string $resourceSignature
	 * @return void
	 */
	public function setResourceSignature($resourceSignature) {
		// TODO: Implement setResourceSignature() method.
	}

	/**
	 * sets the resource parameters
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function setParameters(array $parameters) {
		// TODO: Implement setParameters() method.
	}

	/**
	 * returns the URL which is build depending on the given parameters & base url
	 *
	 * @return string
	 */
	public function getUrl() {
		// TODO: Implement getUrl() method.
	}

	/**
	 * returns the format of the given resource signature
	 *
	 * @return string
	 */
	public function getFormat() {
		// TODO: Implement getFormat() method.
	}
}