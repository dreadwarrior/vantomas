<?php
namespace DreadLabs\Vantomas\Service\Disqus;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (tommy@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use \DreadLabs\Vantomas\Service\Disqus\AbstractApi;

/**
 * Dummy API implementation.
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
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