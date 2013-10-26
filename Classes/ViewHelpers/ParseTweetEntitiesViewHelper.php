<?php
namespace DreadLabs\Vantomas\ViewHelpers;

class ParseTweetEntitiesViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 *
	 * @var string
	 */
	protected $tweet;

	public function initializeArguments() {
		$this->registerArgument('entities', 'object', 'Entities of a tweet.', TRUE);
		$this->registerArgument('urls', 'boolean', 'Flags if urls should be parsed.', FALSE, FALSE);
		$this->registerArgument('hashTags', 'boolean', 'Flags if hash tags should be parsed.', FALSE, FALSE);
	}

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

	protected function parseUrls() {
		foreach ($this->arguments['entities']->urls as $url) {
			$this->tweet = str_replace($url->url, '<a href="' . $url->url . '">' . $url->url . '</a>', $this->tweet);
		}
	}

	protected function parseHashTags() {
		foreach ($this->arguments['entities']->hashtags as $hashTag) {
			$this->tweet = str_replace('#' . $hashTag->text, '<a href="https://twitter.com/search?q=%23' . $hashTag->text . '&src=hash">#' . $hashTag->text . '</a>', $this->tweet);
		}
	}
}
?>