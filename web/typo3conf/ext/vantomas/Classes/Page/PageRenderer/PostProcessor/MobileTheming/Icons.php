<?php
namespace DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\MobileTheming;

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

use DreadLabs\Vantomas\Page\PageRenderer\HookContext\FrontendInterface;
use DreadLabs\Vantomas\Page\PageRenderer\HookInterface;
use DreadLabs\Vantomas\Page\PageRendererAdapter;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Icons
 *
 * @see https://developers.google.com/web/fundamentals/design-and-ui/browser-customization/great-icons?hl=en
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Icons implements HookInterface, FrontendInterface
{

    /**
     * @var TypoScriptFrontendController
     */
    private $controller;

    /**
     * Sets the frontend controller to allow context-specific operations with it.
     *
     * @param TypoScriptFrontendController $controller
     *
     * @return void
     */
    public function setController(TypoScriptFrontendController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Modifies the PageRenderer
     *
     * @param PageRendererAdapter $pageRenderer
     */
    public function modify(PageRendererAdapter $pageRenderer)
    {
        $prefix = '/typo3conf/ext/vantomas/Resources/Public/Images/logo-icons/vantomas-logo-';
        $pageRenderer->addMetaTag('<link rel="icon" sizes="192x192" href="' . $prefix . '192x192.png">');
        $pageRenderer->addMetaTag('<link rel="apple-touch-icon" href="' . $prefix . '180x180.png">');
        $pageRenderer->addMetaTag('<link rel="apple-touch-startup-image" href="' . $prefix . '320x480.png">');
        $pageRenderer->addMetaTag('<meta name="msapplication-square150x150logo" content="' . $prefix . '150x150.png">');
    }
}
