<?php
namespace DreadLabs\VantomasWebsite\Disqus;

interface ResourceInterface {

	/**
	 * sets the base url for the resource
	 *
	 * @param string $baseUrl
	 * @return void
	 */
	public function setBaseUrl($baseUrl);

	/**
	 * sets the resource signature and initiates the concrete resource implementation initialization
	 *
	 * @param string $resourceSignature
	 * @return void
	 */
	public function setResourceSignature($resourceSignature);

	/**
	 * sets the resource parameters
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function setParameters(array $parameters);

	/**
	 * returns the URL which is build depending on the given parameters & base url
	 *
	 * @return string
	 */
	public function getUrl();

	/**
	 * returns the format of the given resource signature
	 *
	 * @return string
	 */
	public function getFormat();
}