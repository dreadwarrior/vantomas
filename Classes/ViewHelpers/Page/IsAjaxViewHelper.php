<?php
class Tx_Vantomas_ViewHelpers_Page_IsAjaxViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	private $headerKey = 'X-Requested-With';

	private $expectedHeaderValue = 'XMLHttpRequest';

	/**
	 *
	 * @param string $then
	 * @param string $else
	 */
	public function render($then, $else) {
		$headerKeyUppercased = strtoupper($this->headerKey);
		$headerKeyUnderscored = str_replace('-', '_', $headerKeyUppercased);

		$currentHeaderValue = t3lib_div::getIndpEnv('HTTP_' . $headerKeyUnderscored);

		$isAjax = $currentHeaderValue === $this->expectedHeaderValue;

		return $isAjax ? $then : $else;
	}
}
?>
