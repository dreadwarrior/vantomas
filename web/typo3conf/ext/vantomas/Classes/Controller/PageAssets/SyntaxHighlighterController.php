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
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * SyntaxHighlighterController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SyntaxHighlighterController extends ActionController implements PageAssetControllerInterface
{

    /**
     * @const string
     */
    const CSS_PATH = 'path:EXT:vantomas/Resources/Public/Css/syntax_highlighter';

    /**
     * @const string
     */
    const JS_PATH = 'path:EXT:vantomas/Resources/Public/Javascript/vendor/syntax_highlighter';

    /**
     * @var FrontendInterface
     */
    private $cache;

    /**
     * @var PageRenderer
     */
    private $pageRenderer;

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
     * @param PageRenderer $pageRenderer
     */
    public function injectPageRenderer(PageRenderer $pageRenderer)
    {
        $this->pageRenderer = $pageRenderer;
    }

    /**
     * Initializes the rendering action.
     *
     * Use this method to add all static assets.
     */
    public function initializeAction()
    {
        if (!$this->cache->has('brushes')) {
            return;
        }

        $themeCss = $this->resolveFilePathReference(
            sprintf(
                self::CSS_PATH . '/shCore%s.css',
                $this->settings['code_snippet']['theme']
            )
        );
        $this->pageRenderer->addCssFile($themeCss);

        $coreJs = $this->resolveFilePathReference(self::JS_PATH . '/shCore.min.js');
        $this->pageRenderer->addJsFooterLibrary('codesnippet_core', $coreJs);

        $autoloaderJs = $this->resolveFilePathReference(self::JS_PATH . '/shAutoloader.min.js');
        $this->pageRenderer->addJsFooterLibrary('codesnippet_autoloader', $autoloaderJs);
    }

    /**
     * Resolves and returns a file path reference.
     *
     * The filePathReference must be given in the ContentObjectRenderer::getData()
     * `path:` format, e.g. 'path:EXT:foo/Resources/css/styles.css'.
     *
     * @param string $filePathReference
     *
     * @return string
     */
    private function resolveFilePathReference($filePathReference)
    {
        return $this->configurationManager->getContentObject()->getData(
            $filePathReference
        );
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
