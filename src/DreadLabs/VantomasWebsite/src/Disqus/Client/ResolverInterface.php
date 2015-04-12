<?php
namespace DreadLabs\VantomasWebsite\Disqus\Client;

interface ResolverInterface {

	/**
	 * Resolves a concrete client implementation
	 *
	 * @param string $clientName
	 * @return AbstractClient
	 */
	public function resolve($clientName);
}