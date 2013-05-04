<?php
namespace DreadLabs\Vantomas\Service\Disqus\Decoder;

class JsonDecoder extends AbstractDecoder {

	public function decode($data) {
		return json_decode($data);
	}
}
?>