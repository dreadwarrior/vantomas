<?php
namespace DreadLabs\VantomasWebsite\Tests\Fixture\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Resource\AbstractResource;

class DummyConcreteResource extends AbstractResource {

	protected $foo = '';

	public function setFoo($foo) {
		$this->foo = $foo;
	}

	public function getPath(array $parameters) {
		return parent::getPath($parameters);
	}
}