<?php
class Tx_Vantomas_Hook_Extension_Beautyofcode implements t3lib_Singleton {

	/**
	 *
	 * @var tx_boc_jquery
	 */
	protected $bocLib = NULL;

	/**
	 *
	 * @var array
	 */
	protected $additionalHeaders = array();

	/**
	 *
	 * @param string $javascriptCode JavaScript inline JS rendered so far
	 * @param boc_jquery $parentObj
	 * @return void
	 */
	public function handleInlineCode(&$javascriptCode, &$parentObj) {
		$this->bocLib = $parentObj;

		if (TRUE === $this->bocLib instanceof boc_jquery) {
			$this->extractInlineCode($javascriptCode);
		}
	}

	protected function extractInlineCode($javascriptCode) {
		$this->getAdditionalHeaders();

		$this->setLibraryHeader();

		$this->setInlineHeader($javascriptCode);

		$this->setAdditionalHeaders();
	}

	protected function getAdditionalHeaders() {
		$additionalHeadersString = $GLOBALS['TSFE']->config['config']['additionalHeaders'];

		$this->additionalHeaders = explode('|', $additionalHeadersString);
	}

	protected function setLibraryHeader() {
		$libraryScriptUrl = $this->bocLib->conf['jquery.']['scriptUrl'];

		$libraryPath = $this->bocLib->boc_div->makeAbsolutePath(trim($libraryScriptUrl));

		$this->additionalHeaders[] = 'X-Beautyofcode-Library: ' . $libraryPath;
	}

	protected function setInlineHeader($javascriptCode) {
		$externalJavascriptCode = $this->cleanupJavascriptCode($javascriptCode);

		$tempFile = TSpagegen::inline2TempFile($externalJavascriptCode, 'js');

		$this->additionalHeaders[] = 'X-Beautyofcode-Inline: ' . $tempFile;
	}

	protected function cleanupJavascriptCode($javascriptCode) {
		$eventHandlingPrefix = $this->getEventHandlingPrefix();

		$cleanedupJavascriptCode = str_replace($eventHandlingPrefix, '', $javascriptCode);
		$cleanedupJavascriptCode = substr(trim($cleanedupJavascriptCode), 0, -3);
		return trim($cleanedupJavascriptCode);
	}

	protected function getEventHandlingPrefix() {
		$jQvar = ($this->bocLib->conf['jQueryNoConflict']) ? "jQuery" : "$";

		$jsCode = "\n";

		// add noConflict jQuery code
		if ($this->bocLib->conf['jQueryNoConflict']) {
			$jsCode .= $jQvar .'.noConflict();'; // . "\n";
		}

		$jsCode .= $jQvar . $this->bocLib->conf['jQueryOnReadyCallback'];

		return $jsCode;
	}

	protected function setAdditionalHeaders() {
		$additionalHeaders = implode('|', $this->additionalHeaders);

		$GLOBALS['TSFE']->config['config']['additionalHeaders'] = $additionalHeaders;
	}
}
?>