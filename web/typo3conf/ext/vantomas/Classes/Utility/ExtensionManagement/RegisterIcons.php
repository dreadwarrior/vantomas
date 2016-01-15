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
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * RegisterIcons
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class RegisterIcons
{
    public static function register()
    {
        $iconRegistry = self::getIconRegistry();

        // -- plugins
        $iconRegistry->registerIcon(
            'vantomas-plugin-archivelist',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/ArchiveList.png',
            ]
        );
        $iconRegistry->registerIcon(
            'vantomas-plugin-archivesearch',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/ArchiveSearch.png',
            ]
        );
        $iconRegistry->registerIcon(
            'vantomas-plugin-sitelastupdatedpages',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/LastUpdatedPages.png',
            ]
        );
        $iconRegistry->registerIcon(
            'vantomas-plugin-disquslatest',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/LatestDisqusComments.png',
            ]
        );
        $iconRegistry->registerIcon(
            'vantomas-plugin-twittertimeline',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/TwitterTimeline.png',
            ]
        );
        $iconRegistry->registerIcon(
            'vantomas-plugin-twittersearch',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/TwitterSearch.png',
            ]
        );
        $iconRegistry->registerIcon(
            'vantomas-plugin-tagcloud',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/TagCloud.png',
            ]
        );
        $iconRegistry->registerIcon(
            'vantomas-plugin-contactform',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/Contact.png',
            ]
        );
        $iconRegistry->registerIcon(
            'vantomas-plugin-secretsanta',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/SecretSanta.png',
            ]
        );

        // -- content elements
        $iconRegistry->registerIcon(
            'vantomas-contentelement-orbiter',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/Orbiter.png',
            ]
        );
        $iconRegistry->registerIcon(
            'vantomas-contentelement-codesnippet',
            SvgIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/CodeSnippet.svg',
            ]
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
}
