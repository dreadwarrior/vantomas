<?php
namespace DreadLabs\Vantomas\Utility;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provides access to \TYPO3\CMS\Core\Utility\ExtensionManagementUtility methods
 *
 * The target of the existence of this class to provide readability to the
 * ext_localconf & ext_tables scripts in the extension root directory.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ExtensionManagement implements SingletonInterface
{
    use ArrayUtilityTrait;

    /**
     * Flexform file reference pattern
     *
     * @var string
     */
    private $flexformFileReferencePattern = 'FILE:EXT:%{extensionKey}%{flexformBasePath}%{flexformFile}';

    /**
     * Base path of the flexform configuration files
     *
     * @var string
     */
    private $flexformFileBasePath = '/Configuration/Flexform/';


    /**
     * A utility method which calls ExtensionManagementUtility::addPiFlexFormValue
     *
     * This method performs the necessary string manipulations which are necessary
     * for extbase based extensions.
     *
     * @param string $extensionKey Mostly $_EXTKEY
     * @param string $pluginName Same value which is passed into
     *                           Tx_Extbase_Utility_Extension::registerPlugin() as a
     *                           second value
     * @param string $flexformFile Last part of the flexform file
     *                             without leading slash
     *
     * @return ExtensionManagement
     *
     * @api
     */
    public function addPluginFlexform($extensionKey, $pluginName, $flexformFile)
    {
        $extensionName = GeneralUtility::underscoredToUpperCamelCase($extensionKey);
        $pluginSignature = strtolower($extensionName . '_' . $pluginName);

        $path = sprintf('TCA|tt_content|types|list|subtypes_addlist|%s', $pluginSignature);
        $value = 'pi_flexform';

        $this->setGlobalArrayPathIfNotSet($path, $value);

        ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            $this->getFlexformFileReference($extensionKey, $flexformFile)
        );

        return $this;
    }

    /**
     * Returns a flexform file reference
     *
     * @param string $extensionKey Extension key
     * @param string $flexformFile Flexform file name
     *
     * @return string
     */
    private function getFlexformFileReference($extensionKey, $flexformFile)
    {
        $replacePairs = [
            '%{extensionKey}' => $extensionKey,
            '%{flexformBasePath}' => $this->flexformFileBasePath,
            '%{flexformFile}' => $flexformFile,
        ];

        return strtr(
            $this->flexformFileReferencePattern,
            $replacePairs
        );
    }
}
