<?php
class Tx_Vantomas_ViewHelpers_Request_IsMobileViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('host', 'string', 'The expected host string', TRUE);
		$this->registerArgument('negate', 'boolean', 'Negates the return value', FALSE, FALSE);
	}

	/**
	 *
	 * @return boolean
	 */
	public function render() {
		$isMobile = $this->isExpectedHost();

		if ($this->arguments['negate']) {
			return !$isMobile;
		} else {
			return $isMobile;
		}
	}

	private function isExpectedHost() {
		$currentHost = t3lib_div::getIndpEnv('HTTP_HOST');
		$isExpectedHost = $this->arguments['host'] === $currentHost;

		return $isExpectedHost;
	}
}
?>