<?php
namespace DreadLabs\VantomasWebsite\Disqus\Client;

use DreadLabs\VantomasWebsite\Disqus\ResourceInterface;
use DreadLabs\VantomasWebsite\Disqus\ResponseInterface;

abstract class AbstractClient {

	/**
	 * tells the client to which endpoint it has to connect
	 *
	 * @var ResourceInterface $resource
	 * @return void
	 */
	abstract public function connectTo(ResourceInterface $resource);

	/**
	 * returns the response for further processing or simple content fetching
	 *
	 * @return ResponseInterface
	 */
	abstract public function getResponse();

	/**
	 * disconnects the client
	 *
	 * Implement library dependent cleanup and disconnect logic here
	 *
	 * @return void
	 */
	abstract public function disconnect();
}