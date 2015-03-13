<?php
namespace DreadLabs\VantomasWebsite\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Client\AbstractClient;
use DreadLabs\VantomasWebsite\Disqus\Client\ResolverInterface;

class Client implements ClientInterface {

	/**
	 * the client name of a concrete client class in this extension
	 *
	 * @var string
	 */
	protected $clientName = 'Curl';

	/**
	 *
	 * @var ResolverInterface
	 */
	protected $clientResolver;

	/**
	 *
	 * @var AbstractClient
	 */
	protected $concreteClient;

	/**
	 *
	 * @var ResponseInterface
	 */
	protected $response;

	/**
	 * @param ResolverInterface $clientResolver
	 */
	public function __construct(
		ResolverInterface $clientResolver
	) {
		$this->clientResolver = $clientResolver;
	}

	/**
	 * {@inheritdoc}
	 */
	public function connectWith($clientName) {
		$this->concreteClient = $this->clientResolver->resolve($clientName);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function connectTo(ResourceInterface $resource) {
		$this->concreteClient->connectTo($resource);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function send() {
		$this->response = $this->concreteClient->getResponse();

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function disconnect() {
		$this->concreteClient->disconnect();

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getResponse() {
		return $this->response;
	}
}