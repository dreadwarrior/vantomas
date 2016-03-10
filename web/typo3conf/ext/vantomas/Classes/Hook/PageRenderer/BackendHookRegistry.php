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

use DreadLabs\Vantomas\Page\PageRenderer\HookContext\BackendInterface;
use DreadLabs\Vantomas\Page\PageRenderer\HookInterface;
use DreadLabs\Vantomas\Page\PageRendererAdapter;
use TYPO3\CMS\Backend\Controller\BackendController;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * BackendHookRegistry
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class BackendHookRegistry implements SingletonInterface
{

    /**
     * @var array
     */
    private $postProcessors = [];

    /**
     * @param BackendInterface $hook
     *
     * @return BackendHookRegistry
     */
    public function addPostProcessor(BackendInterface $hook)
    {
        array_push($this->postProcessors, $hook);

        return $this;
    }

    /**
     * Hooks into BackendController post-construction
     */
    public function register()
    {
        if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess'])) {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess'] = [];
        }

        array_push(
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess'],
            sprintf('%s->%s', __CLASS__, 'registerPostProcessors')
        );
    }

    /**
     * Hooks into PageRenderer post processing
     *
     * @param array $parameters Construction parameters, currently empty
     * @param BackendController $controller Reference to BackendController
     *
     * @return void
     *
     * @see BackendController::__construct
     */
    public function registerPostProcessors(array &$parameters, BackendController &$controller)
    {
        if (0 === count($this->postProcessors)) {
            return;
        }

        array_walk($this->postProcessors, function (BackendInterface $processor) use ($controller) {
            $processor->setController($controller);
        });

        if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'])) {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'] = [];
        }

        array_push(
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'],
            sprintf('%s->%s', __CLASS__, 'executePostProcessors')
        );
    }

    /**
     * @param array $parameters
     * @param PageRenderer $pageRenderer
     *
     * @return void
     *
     * @see PageRenderer::executePostRenderHook
     */
    public function executePostProcessors(array &$parameters, PageRenderer &$pageRenderer)
    {
        $pageRendererAdapter = new PageRendererAdapter($pageRenderer, $parameters);

        array_walk($this->postProcessors, function (HookInterface $processor) use ($pageRendererAdapter) {
            $processor->modify($pageRendererAdapter);
        });

        $parameters = $pageRendererAdapter->getParameters();
        $pageRenderer = $pageRendererAdapter->getPageRenderer();
    }
}
