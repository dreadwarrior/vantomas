<?php
namespace DreadLabs\VantomasWebsite\Disqus\Response;

interface ResolverInterface {

	/**
	 * @param string $format
	 * @return AbstractResponse
	 */
	public function resolve($format);
}