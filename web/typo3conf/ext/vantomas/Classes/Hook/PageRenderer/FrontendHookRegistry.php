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

use DreadLabs\Vantomas\Page\PageRenderer\HookContext\FrontendInterface;
use DreadLabs\Vantomas\Page\PageRenderer\HookInterface;
use DreadLabs\Vantomas\Page\PageRendererAdapter;
use DreadLabs\Vantomas\Utility\ArrayUtilityTrait;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * FrontendHookRegistry
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FrontendHookRegistry implements SingletonInterface
{
    use ArrayUtilityTrait;

    /**
     * @var array
     */
    private $postProcessors = [];

    /**
     * @param FrontendInterface $hook
     *
     * @return FrontendHookRegistry
     */
    public function addPostProcessor(FrontendInterface $hook)
    {
        array_push($this->postProcessors, $hook);

        return $this;
    }

    /**
     * Hooks into TSFE post-construction
     */
    public function register()
    {
        $path = 'TYPO3_CONF_VARS|SC_OPTIONS|tslib/class.tslib_fe.php|tslib_fe-PostProc';
        $value = sprintf('%s->%s', __CLASS__, 'registerPostProcessors');

        $this->pushToGlobalArrayByArrayPath($path, $value);
    }

    /**
     * Hooks into PageRenderer post processing
     *
     * @param array $parameters Associative array with a single key: `pObj`, holding a reference to TSFE
     * @param TypoScriptFrontendController $controller Reference to TSFE
     *
     * @return void
     *
     * @see TypoScriptFrontendController::__construct
     */
    public function registerPostProcessors(array &$parameters, TypoScriptFrontendController &$controller)
    {
        if (0 === count($this->postProcessors)) {
            return;
        }

        array_walk($this->postProcessors, function (FrontendInterface $processor) use ($controller) {
            $processor->setController($controller);
        });

        $path = 'TYPO3_CONF_VARS|SC_OPTIONS|t3lib/class.t3lib_pagerenderer.php|render-postProcess';
        $value = sprintf('%s->%s', __CLASS__, 'executePostProcessors');

        $this->pushToGlobalArrayByArrayPath($path, $value);
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
