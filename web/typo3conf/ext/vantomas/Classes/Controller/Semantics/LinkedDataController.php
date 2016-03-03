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

use DreadLabs\Vantomas\Page\PageType;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * LinkedDataController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class LinkedDataController extends ActionController
{

    public function initializeAction()
    {
        $this->request->setFormat('jsonld');
    }

    /**
     * @return string
     */
    public function generateAction()
    {
        $contentObject = $this->configurationManager->getContentObject();

        if ((int) $contentObject->data['doktype'] !== PageType::BLOG_ARTICLE) {
            $this->getTypoScriptFrontendController()->pageNotFoundAndExit(
                'Page not found.'
            );
        }

        $this->view->assign('settings', $this->settings);
        $this->view->assign('data', $contentObject->data);
    }

    /**
     * @return TypoScriptFrontendController
     */
    private function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
