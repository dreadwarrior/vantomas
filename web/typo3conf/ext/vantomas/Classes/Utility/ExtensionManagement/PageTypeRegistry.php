<?php
namespace DreadLabs\Vantomas\Utility\ExtensionManagement;

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

use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Registers new page types (doktype in TYPO3.CMS)
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PageTypeRegistry
{

    /**
     * Registers the page type
     *
     * @param int $pageType Page type (doktype)
     * @param string $identifier The icon identifier
     * @param string $iconFileReference The Icon file reference (e.g. 'EXT:foo/res/pub/bar.png')
     *
     * @return void
     */
    public static function registerPageType($pageType, $identifier, $iconFileReference)
    {
        self::registerPageTypeIcon($identifier, $iconFileReference);
        self::registerTypeInPageTreeDragArea($pageType);
    }

    /**
     * Registers the page type in the TCA
     *
     * @param string $identifier The icon identifier
     * @param string $iconFileReference The Icon file reference (e.g. 'EXT:foo/res/pub/bar.png')
     *
     * @return void
     */
    private static function registerPageTypeIcon($identifier, $iconFileReference)
    {
        $iconRegistry = self::getIconRegistry();
        $iconRegistry->registerIcon(
            $identifier,
            BitmapIconProvider::class,
            array(
                'source' => $iconFileReference,
            )
        );
    }

    /**
     * Returns the IconRegistry
     *
     * @return IconRegistry
     */
    private static function getIconRegistry()
    {
        $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);

        return $iconRegistry;
    }

    /**
     * Registers the page type in the PageTree drag area
     *
     * @param int $pageType Page type
     *
     * @return void
     */
    private static function registerTypeInPageTreeDragArea($pageType)
    {
        ExtensionManagementUtility::addUserTSConfig(
            'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $pageType . ')'
        );
    }
}
