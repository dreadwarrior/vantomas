<?php
namespace DreadLabs\VantomasWebsite\Disqus\Resource;

interface ResolverInterface {

	/**
	 * Resolves a concrete resource by topic + action
	 *
	 * @param string $topic
	 * @param string $action
	 * @return AbstractResource
	 */
	public function resolve($topic, $action);
}