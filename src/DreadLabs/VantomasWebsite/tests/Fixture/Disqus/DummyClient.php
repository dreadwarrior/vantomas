<?php
namespace DreadLabs\VantomasWebsite\Tests\Fixture\Disqus;

use DreadLabs\VantomasWebsite\Disqus\ClientInterface;
use DreadLabs\VantomasWebsite\Disqus\ResourceInterface;
use DreadLabs\VantomasWebsite\Disqus\ResponseInterface;

class DummyClient implements ClientInterface {

	/**
	 * sets the internal client name property and should initialize a concrete client implementation
	 *
	 * @param string $clientName
	 * @return ClientInterface
	 */
	public function connectWith($clientName) {
		// TODO: Implement connectWith() method.
	}

	/**
	 * connects the client in any manner
	 *
	 * Implement this method to create ressources, set options of your 3rd party
	 * client library etc.
	 *
	 * @param ResourceInterface $resource
	 * @return ClientInterface
	 */
	public function connectTo(ResourceInterface $resource) {
		// TODO: Implement connectTo() method.
	}

	/**
	 * sends the actual request
	 *
	 * @return ClientInterface
	 */
	public function send() {
		// TODO: Implement send() method.
	}

	/**
	 * disconnects the client in any manner
	 *
	 * Implement this method to destroy ressources, perform cleanup tasks etc.
	 *
	 * @return ClientInterface
	 */
	public function disconnect() {
		// TODO: Implement disconnect() method.
	}

	/**
	 * returns the response for further processing
	 *
	 * @return ResponseInterface
	 */
	public function getResponse() {
		// TODO: Implement getResponse() method.
	}
}