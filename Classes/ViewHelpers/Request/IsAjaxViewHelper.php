<?php
class Tx_Vantomas_ViewHelpers_Request_IsAjaxViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('expectedHost', 'string', 'The expected host string', TRUE);
		$this->registerArgument('expectedXRequestedWith', 'string', 'The expected X-Requested-With header string', TRUE);
		$this->registerArgument('negate', 'boolean', 'Negates the return value', FALSE, FALSE);
	}

	/**
	 *
	 * @return boolean
	 */
	public function render() {
		$isAjaxRequest = $this->isAjaxRequest();

		if ($this->arguments['negate']) {
			return !$isAjaxRequest;
		} else {
			return $isAjaxRequest;
		}
	}

	private function isAjaxRequest() {
		$isExpectedHost = $this->isExpectedHost();
		$isExpectedXRequestedWith = $this->isExpectedXRequestedWith();

		return $isExpectedHost && $isExpectedXRequestedWith;
	}

	private function isExpectedHost() {
		$currentHost = t3lib_div::getIndpEnv('HTTP_HOST');
		$isExpectedHost = $this->arguments['expectedHost'] === $currentHost;

		return $isExpectedHost;
	}

	private function isExpectedXRequestedWith() {
		$currentXRequestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'];
		$isExpectedXRequestedWith = $this->arguments['expectedXRequestedWith'] === $currentXRequestedWith;

		return $isExpectedXRequestedWith;
	}
}
?>