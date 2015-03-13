<?php
namespace DreadLabs\VantomasWebsite\Tests\Fixture\Disqus;

use DreadLabs\VantomasWebsite\Disqus\Response\AbstractResponse;

class DummyResponse extends AbstractResponse {

	public function setContent($content) {
		$this->content = $content;
	}
}