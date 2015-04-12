<?php
namespace DreadLabs\VantomasWebsite\Disqus;

/**
 * Api interface.
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
interface ApiInterface {

	/**
	 * sets the client to use as API connection client
	 *
	 * @param string $clientName Client name in lower_underscored_format.
	 * @return ApiInterface
	 */
	public function connectWith($clientName);

	/**
	 * tells the API which resource to call
	 *
	 * @link http://disqus.com/api/docs/#resources full list of available DISQUS API resources.	 *
	 *
	 * @param string $resourceSignature Format is: "topic/endpoint.format". E.g.: forums/listPosts.json.
	 * @return ApiInterface
	 */
	public function execute($resourceSignature);

	/**
	 * sets the resources parameters
	 *
	 * This method must set the API key.
	 *
	 * @param array $parameters Resource parameters
	 * @return ApiInterface
	 */
	public function with(array $parameters);
}