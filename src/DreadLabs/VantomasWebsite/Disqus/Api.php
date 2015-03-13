<?php
namespace DreadLabs\VantomasWebsite\Disqus;

class Api implements ApiInterface {

	/**
	 * @var ConfigurationInterface
	 */
	private $configuration;

	/**
	 * @var ClientInterface
	 */
	private $client;

	/**
	 * @var ResourceInterface
	 */
	private $resource;

	/**
	 * @param ConfigurationInterface $configuration
	 * @param ClientInterface $client
	 * @param ResourceInterface $resource
	 */
	public function __construct(
		ConfigurationInterface $configuration,
		ClientInterface $client,
		ResourceInterface $resource
	) {
		$this->configuration = $configuration;
		$this->client = $client;
		$this->resource = $resource;
	}

	/**
	 * {@inheritdoc}
	 */
	public function connectWith($clientName) {
		$this->client->connectWith($clientName);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function execute($resourceSignature) {
		$this->resource->setBaseUrl($this->configuration->getBaseUrl());
		$this->resource->setResourceSignature($resourceSignature);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function with(array $parameters) {
		$parameters['api_key'] = $this->configuration->getApiKey();

		$this->resource->setParameters($parameters);

		$response = $this->client
			->connectTo($this->resource)
			->send()
			->disconnect()
			->getResponse();

		return $response->getContent();
	}
}