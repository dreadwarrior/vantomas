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

use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry as CoreIconRegistry;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * IconRegistry
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class IconRegistry implements SingletonInterface
{

    /**
     * @var CoreIconRegistry
     */
    private $coreRegistry;

    public function __construct(CoreIconRegistry $registry)
    {
        $this->coreRegistry = $registry;
    }

    public function register()
    {
        $this->registerDoktypeIcons();
        $this->registerPluginIcons();
        $this->registerContentElementIcons();
    }

    private function registerDoktypeIcons()
    {
        $this->coreRegistry->registerIcon(
            'vantomas-blog-article',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Images/doktype-blog-article.png',
            ]
        );
    }

    private function registerPluginIcons()
    {
        $this->coreRegistry->registerIcon(
            'vantomas-plugin-archivelist',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/ArchiveList.png',
            ]
        );
        $this->coreRegistry->registerIcon(
            'vantomas-plugin-archivesearch',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/ArchiveSearch.png',
            ]
        );
        $this->coreRegistry->registerIcon(
            'vantomas-plugin-sitelastupdatedpages',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/LastUpdatedPages.png',
            ]
        );
        $this->coreRegistry->registerIcon(
            'vantomas-plugin-disquslatest',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/LatestDisqusComments.png',
            ]
        );
        $this->coreRegistry->registerIcon(
            'vantomas-plugin-twittertimeline',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/TwitterTimeline.png',
            ]
        );
        $this->coreRegistry->registerIcon(
            'vantomas-plugin-twittersearch',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/TwitterSearch.png',
            ]
        );
        $this->coreRegistry->registerIcon(
            'vantomas-plugin-tagcloud',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/TagCloud.png',
            ]
        );
        $this->coreRegistry->registerIcon(
            'vantomas-plugin-contactform',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/Contact.png',
            ]
        );
        $this->coreRegistry->registerIcon(
            'vantomas-plugin-secretsanta',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/SecretSanta.png',
            ]
        );
    }

    private function registerContentElementIcons()
    {
        $this->coreRegistry->registerIcon(
            'vantomas-contentelement-orbiter',
            BitmapIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/Orbiter.png',
            ]
        );
        $this->coreRegistry->registerIcon(
            'vantomas-contentelement-codesnippet',
            SvgIconProvider::class,
            [
                'source' => 'EXT:vantomas/Resources/Public/Icons/CodeSnippet.svg',
            ]
        );
    }
}
