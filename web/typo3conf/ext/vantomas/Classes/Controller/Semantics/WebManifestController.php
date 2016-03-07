<?php
namespace DreadLabs\Vantomas\Controller\Semantics;

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

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * WebManifestController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class WebManifestController extends ActionController
{

    public function initializeAction()
    {
        $this->request->setFormat('json');
    }

    public function generateAction()
    {
        if ((int) $this->configurationManager->getContentObject()->getData('level') !== 0) {
            $this->getTypoScriptFrontendController()->pageNotFoundAndExit(
                'Page not found.'
            );
        }
    }

    /**
     * @return TypoScriptFrontendController
     */
    private function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
