<?php
namespace DreadLabs\Vantomas\Controller\PageAssets;

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

use DreadLabs\Vantomas\Mvc\Controller\PageAssetControllerInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * SyntaxHighlighterController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SyntaxHighlighterController extends ActionController implements PageAssetControllerInterface
{

    /**
     * @var FrontendInterface
     */
    private $cache;

    /**
     * @param CacheManager $cacheManager
     *
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    public function injectCacheManager(CacheManager $cacheManager)
    {
        $this->cache = $cacheManager->getCache('codesnippet_brushes');
    }

    /**
     * Initializes the rendering action.
     *
     * Use this method to add all static assets.
     */
    public function initializeAction()
    {
        $pageRenderer = $this->getTypoScriptFrontendController()->getPageRenderer();

        if ($this->cache->has('brushes')) {
            $pageRenderer->addCssFile(
                $this->configurationManager->getContentObject()->getData(
                    sprintf(
                        'path:EXT:vantomas/Resources/Public/Css/syntax_highlighter/shCore%s.css',
                        $this->settings['code_snippet']['theme']
                    )
                )
            );

            $pageRenderer->addJsFooterLibrary(
                'codesnippet_core',
                $this->configurationManager->getContentObject()->getData(
                    'path:EXT:vantomas/Resources/Public/Javascript/vendor/syntax_highlighter/shCore.min.js'
                )
            );
            $pageRenderer->addJsFooterLibrary(
                'codesnippet_autoloader',
                $this->configurationManager->getContentObject()->getData(
                    'path:EXT:vantomas/Resources/Public/Javascript/vendor/syntax_highlighter/shAutoloader.min.js'
                )
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

    public function jsFooterInlineAction()
    {
        if (!$this->cache->has('brushes')) {
            return '';
        }

        // arguments for the AddPageAssetListenerInterface implementation
        $this->request->setArgument('compress', false);
        $this->request->setArgument('forceOnTop', false);

        $this->view->assign('brushes', $this->cache->get('brushes'));
    }
}
