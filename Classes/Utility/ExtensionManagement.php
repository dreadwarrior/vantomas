<?php
class Tx_Vantomas_Utility_ExtensionManagement implements t3lib_Singleton {

	protected static $flexformFileReferenceFormat = 'FILE:EXT:%{extensionKey}%{flexformBasePath}%{flexformFile}';

	protected static $flexformBasePath = '/Configuration/Flexform/';

	/**
	 * A utility method which calls t3lib_extMgm::addPiFlexFormValue
	 *
	 * This method performs the necessary string manipulations which are necessary
	 * for extbase based extensions.
	 *
	 * @param string $extensionKey mostly $_EXTKEY
	 * @param string $pluginName same value which is passed into Tx_Extbase_Utility_Extension::registerPlugin() as a second value
	 * @param string $flexformFile last part of the flexform file without leading slash
	 * @return void
	 * @api
	 */
	public static function addPluginFlexform($extensionKey, $pluginName, $flexformFile) {
		$extensionName = t3lib_div::underscoredToUpperCamelCase($extensionKey);

		$pluginSignature = strtolower($extensionName . '_' . $pluginName);

		$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

		$replacePairs = array(
			'%{extensionKey}' => $extensionKey,
			'%{flexformBasePath}' => self::$flexformBasePath,
			'%{flexformFile}' => $flexformFile
		);

		$flexformFileReference = strtr(self::$flexformFileReferenceFormat, $replacePairs);

		t3lib_extMgm::addPiFlexFormValue($pluginSignature, $flexformFileReference);
	}
}
?>