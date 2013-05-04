<?php
namespace DreadLabs\Vantomas\Service\Disqus\Method;

interface MethodInterface {

	public function getUrl(array $parameters);

	public function getFormat();
}
?>