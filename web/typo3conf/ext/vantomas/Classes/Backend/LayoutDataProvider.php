<?php
namespace DreadLabs\Vantomas\Backend;

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

use TYPO3\CMS\Backend\View\BackendLayout\BackendLayout;
use TYPO3\CMS\Backend\View\BackendLayout\BackendLayoutCollection;
use TYPO3\CMS\Backend\View\BackendLayout\DataProviderContext;
use TYPO3\CMS\Backend\View\BackendLayout\DataProviderInterface;
use TYPO3\CMS\Backend\View\BackendLayoutView;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * LayoutDataProvider
 *
 * Provides all layouts shipped with ext:vantomas
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class LayoutDataProvider implements DataProviderInterface, SingletonInterface
{

    /**
     * Extension key
     *
     * @var string
     */
    const EXTENSION_KEY = 'vantomas';

    /**
     * Layout path in ext:vantomas
     *
     * @var string
     */
    const LAYOUT_PATH = 'Configuration/BackendLayouts/';

    /**
     * Register backend layout provider
     *
     * @NOTE: last key in hook here is prefix for the layout identifier.
     */
    public function register()
    {
        if (!isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['BackendLayoutDataProvider'])) {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['BackendLayoutDataProvider'] = [];
        }

        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['BackendLayoutDataProvider'][self::EXTENSION_KEY] = __CLASS__;
    }

    /**
     * Adds backend layouts to the given backend layout collection.
     *
     * @param DataProviderContext $dataProviderContext
     * @param BackendLayoutCollection $backendLayoutCollection
     * @return void
     */
    public function addBackendLayouts(
        DataProviderContext $dataProviderContext,
        BackendLayoutCollection $backendLayoutCollection
    ) {
        $files = $this->getLayoutFiles();

        foreach ($files as $file) {
            $backendLayoutCollection->add($file->toBackendLayout());
        }
    }

    /**
     * GetLayoutFiles
     *
     * @return LayoutFileInfo[] Empty array if an error occurred
     */
    private function getLayoutFiles()
    {
        $absolutePath = ExtensionManagementUtility::extPath(self::EXTENSION_KEY, self::LAYOUT_PATH);

        $files = GeneralUtility::getFilesInDir($absolutePath, LayoutFileInfo::EXTENSION, true);

        if (!is_array($files)) {
            return [];
        }

        array_walk($files, function (&$file) {
            $absoluteFilePath = $file;
            $file = new LayoutFileInfo($absoluteFilePath);
        });

        return $files;
    }

    /**
     * Gets a backend layout by (regular) identifier.
     *
     * @param string $identifier
     * @param int $pageId
     * @return NULL|BackendLayout
     */
    public function getBackendLayout($identifier, $pageId)
    {
        $backendLayout = $this->getDefaultBackendLayout();

        $files = $this->getLayoutFiles();

        foreach ($files as $file) {
            if ($identifier !== $file->getIdentifier()) {
                continue;
            }

            $backendLayout = $file->toBackendLayout();
        }

        return $backendLayout;
    }

    /**
     * GetDefaultBackendLayout
     *
     * @return BackendLayout
     */
    private function getDefaultBackendLayout()
    {
        return BackendLayout::create(
            'default',
            'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.backend_layout.default',
            BackendLayoutView::getDefaultColumnLayout()
        );
    }
}
