<?php
namespace DreadLabs\Vantomas\Service\Disqus;

use \DreadLabs\Vantomas\Service\Disqus\AbstractApi;

class DummyApi extends AbstractApi {

	public function loadData() {
		$result = '{
    "response": [{
            "author": {
                "name": "Max Mustermann"
            },
            "raw_message": "[DUMMY#1] This is a text excerpt",
            "id": "123456789",
            "thread": {
                "title": "[DUMMY#1] A page on your site",
                "link": "http://www.example.org/"
            }
        }, {
            "author": {
                "name": "Foo Bar"
            },
            "raw_message": "7DUMMY#2] This is a text excerpt",
            "id": "987654321",
            "thread": {
                "title": "[DUMMY#2] A page on your site",
                "link": "http://www.example.org/"
            }
        }, {
            "author": {
                "name": "What Ever"
            },
            "raw_message": "[DUMMY#3] This is a text excerpt",
            "id": "192837465",
            "thread": {
                "title": "[DUMMY#3] A page on your site",
                "link": "http://www.example.org/"
            }
        }
    ]
}';

		return $result;
	}

	protected function createClient() {
		// file handle
	}

	protected function sendRequest() {
		// read from file
	}

	protected function destroyClient() {
		// close file
	}
}
?>