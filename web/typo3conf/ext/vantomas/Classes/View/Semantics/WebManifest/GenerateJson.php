<?php
namespace DreadLabs\Vantomas\View\Semantics\WebManifest;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\View\AbstractView;

/**
 * GenerateJson
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class GenerateJson extends AbstractView
{

    /**
     * @var string
     */
    private $imagePathPrefix = 'EXT:vantomas/Resources/Public/Images/logo-icons/vantomas-logo-';

    /**
     * Renders the view
     *
     * @return string The rendered view
     * @api
     */
    public function render()
    {
        $data = [
            'lang' => 'en',
            'name' => 'van-tomas.de - TYPO3, Ubuntu, Open Source & Webdevelopment',
            'short_name' => 'van-tomas.de',
            'icons' => $this->getIcons(),
            'splash_screens' => $this->getSplashScreens(),
            'start_url' => '/',
            'display' => 'fullscreen',
            'orientation' => 'portrait',
            'theme_color' => '#fa9f4e',
            'background_color' => 'white',
        ];

        return json_encode((object) $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    private function getIcons()
    {
        $icons = [];

        array_push($icons, [
            'src' => $this->getImagePath('150x150.png'),
            'sizes' => '150x150',
            'type' => 'image/png',
        ]);

        array_push($icons, [
            'src' => $this->getImagePath('180x180.png'),
            'sizes' => '180x180',
            'type' => 'image/png',
        ]);

        array_push($icons, [
            'src' => $this->getImagePath('192x192.png'),
            'size' => '192x192',
            'type' => 'image/png',
        ]);

        return $icons;
    }

    private function getImagePath($fileNameWithSuffix)
    {
        return PathUtility::stripPathSitePrefix(
            GeneralUtility::getFileAbsFileName($this->imagePathPrefix . $fileNameWithSuffix)
        );
    }

    private function getSplashScreens()
    {
        $splashScreens = [];

        array_push($splashScreens, [
            'src' => $this->getImagePath('320x480.png'),
            'size' => '320x480',
            'type' => 'image/png',
        ]);

        return $splashScreens;
    }
}
