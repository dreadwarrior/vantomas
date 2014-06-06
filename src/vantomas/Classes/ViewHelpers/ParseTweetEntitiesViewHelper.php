<?php
namespace DreadLabs\Vantomas\ViewHelpers;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Thomas Juhnke (typo3@van-tomas.de)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * ParseTweetEntitiesViewHelper
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ParseTweetEntitiesViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 *
	 * @var string
	 */
	protected $tweet;

	/**
	 * Initializes the VH arguments
	 *
	 * @return void
	 * @see \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper::initializeArguments()
	 */
	public function initializeArguments() {
		$this->registerArgument('entities', 'object', 'Entities of a tweet.', TRUE);
		$this->registerArgument('urls', 'boolean', 'Flags if urls should be parsed.', FALSE, FALSE);
		$this->registerArgument('hashTags', 'boolean', 'Flags if hash tags should be parsed.', FALSE, FALSE);
	}

	/**
	 * Renders the VH
	 *
	 * @return string
	 */
	public function render() {
		$this->tweet = $this->renderChildren();

		if ($this->arguments['urls'] === TRUE) {
			$this->parseUrls();
		}
		if ($this->arguments['hashTags'] === TRUE) {
			$this->parseHashTags();
		}

		return $this->tweet;
	}

	/**
	 * Parses URL entities
	 *
	 * @return void
	 */
	protected function parseUrls() {
		foreach ($this->arguments['entities']->urls as $url) {
			$this->tweet = str_replace($url->url, '<a href="' . $url->url . '">' . $url->url . '</a>', $this->tweet);
		}
	}

	/**
	 * Parses hash tag entities
	 *
	 * @return void
	 */
	protected function parseHashTags() {
		foreach ($this->arguments['entities']->hashtags as $hashTag) {
			$this->tweet = str_replace('#' . $hashTag->text, '<a href="https://twitter.com/search?q=%23' . $hashTag->text . '&src=hash">#' . $hashTag->text . '</a>', $this->tweet);
		}
	}
}