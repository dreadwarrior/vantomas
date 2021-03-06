<?php
namespace DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\MobileExperience;

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
 * Colors
 *
 * Sets the color for browser / ui elements for various platforms.
 *
 * @see https://developers.google.com/web/fundamentals/design-and-ui/browser-customization/theme-color?hl=en
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Colors implements HookInterface, FrontendInterface
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
        // Chrome, Firefox OS and Opera
        $pageRenderer->addMetaTag('<meta name="theme-color" content="#fa9f4e">');
        // Windows Phone
        $pageRenderer->addMetaTag('<meta name="msapplication-navbutton-color" content="#fa9f4e">');
        // iOS Safari
        $pageRenderer->addMetaTag('<meta name="apple-mobile-web-app-capable" content="yes">');
        $pageRenderer->addMetaTag('<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">');
    }
}
