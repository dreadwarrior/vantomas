<?php
namespace DreadLabs\Vantomas\Hook\PageRenderer;

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

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * AbstractFrontendPostProcessor
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
abstract class AbstractFrontendPostProcessor
{

    /**
     * @var TypoScriptFrontendController
     */
    protected $typoscriptFrontendController;

    /**
     * @var ContentObjectRenderer
     */
    protected $pageContentObjectRenderer;

    /**
     * @return bool
     */
    protected function canRender()
    {
        $isFrontendMode = TYPO3_MODE === 'FE';

        if (!$isFrontendMode) {
            return false;
        }

        $this->typoscriptFrontendController = $GLOBALS['TSFE'];
        $this->pageContentObjectRenderer = $this->typoscriptFrontendController->cObj;

        return true;
    }
}
