<?php
namespace DreadLabs\VantomasWebsite\Disqus\Response;

class Json extends AbstractResponse {

	/**
	 * performs a json_decode() call on the passed $content parameter
	 *
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = json_decode($content);
	}
}