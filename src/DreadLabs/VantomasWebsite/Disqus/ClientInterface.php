<?php
namespace DreadLabs\VantomasWebsite\Disqus;

interface ClientInterface {

	/**
	 * sets the internal client name property and should initialize a concrete client implementation
	 *
	 * @param string $clientName
	 * @return ClientInterface
	 */
	public function connectWith($clientName);

	/**
	 * connects the client in any manner
	 *
	 * Implement this method to create ressources, set options of your 3rd party
	 * client library etc.
	 *
	 * @param ResourceInterface $resource
	 * @return ClientInterface
	 */
	public function connectTo(ResourceInterface $resource);

	/**
	 * sends the actual request
	 *
	 * @return ClientInterface
	 */
	public function send();

	/**
	 * disconnects the client in any manner
	 *
	 * Implement this method to destroy ressources, perform cleanup tasks etc.
	 *
	 * @return ClientInterface
	 */
	public function disconnect();

	/**
	 * returns the response for further processing
	 *
	 * @return ResponseInterface
	 */
	public function getResponse();
}