<?php
namespace DreadLabs\Vantomas\Hook\TypoScriptFrontendController;

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

use DreadLabs\Vantomas\Frontend\Controller\ContentPostProcessorInterface;
use DreadLabs\Vantomas\Frontend\ControllerAdapter;
use DreadLabs\Vantomas\Utility\ArrayUtilityTrait;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * ContentPostProcessorHookRegistry
 *
 * Registry for TypoScriptFrontendController content post processors.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ContentPostProcessorHookRegistry implements SingletonInterface
{
    use ArrayUtilityTrait;

    /**
     * @var ContentPostProcessorInterface[]
     */
    private $startProcessors = [];

    /**
     * @var ContentPostProcessorInterface[]
     */
    private $beforeCacheProcessors = [];

    /**
     * @var ContentPostProcessorInterface[]
     */
    private $beforeOutputProcessors = [];

    /**
     * @param ContentPostProcessorInterface $postProcessor
     *
     * @return ContentPostProcessorHookRegistry
     */
    public function processOnStart(ContentPostProcessorInterface $postProcessor)
    {
        array_push($this->startProcessors, $postProcessor);

        return $this;
    }

    /**
     * @param ContentPostProcessorInterface $postProcessor
     *
     * @return ContentPostProcessorHookRegistry
     */
    public function processOnBeforeCache(ContentPostProcessorInterface $postProcessor)
    {
        array_push($this->beforeCacheProcessors, $postProcessor);

        return $this;
    }

    /**
     * @param ContentPostProcessorInterface $postProcessor
     *
     * @return ContentPostProcessorHookRegistry
     */
    public function processOnBeforeOutput(ContentPostProcessorInterface $postProcessor)
    {
        array_push($this->beforeOutputProcessors, $postProcessor);

        return $this;
    }

    public function register()
    {
        $this->registerOnStart();
        $this->registerOnBeforeCache();
        $this->registerOnBeforeOutput();
    }

    /**
     * Registers handling the `contentPostProc-all` hook
     *
     * Hook for post-processing of page content cached/non-cached ("on start of post processing")
     *
     * @see TypoScriptFrontendController::generatePage_postProcessing
     */
    private function registerOnStart()
    {
        if (0 === count($this->startProcessors)) {
            return;
        }

        $path = 'TYPO3_CONF_VARS|SC_OPTIONS|tslib/class.tslib_fe.php|contentPostProc-all';
        $value = sprintf('%s->%s', __CLASS__, 'executeOnStartPostProcessors');

        $this->pushToGlobalArrayByArrayPath($path, $value);
    }

    /**
     * Registers handling the `contentPostProc-cache` hook
     *
     * Hook for post-processing of page content before being cached
     *
     * @see TypoScriptFrontendController::generatePage_postProcessing
     */
    private function registerOnBeforeCache()
    {
        if (0 === count($this->beforeCacheProcessors)) {
            return;
        }

        $path = 'TYPO3_CONF_VARS|SC_OPTIONS|tslib/class.tslib_fe.php|contentPostProc-cache';
        $value = sprintf('%s->%s', __CLASS__, 'executeOnBeforeCachePostProcessors');

        $this->pushToGlobalArrayByArrayPath($path, $value);
    }

    /**
     * Registers handling the `contentPostProc-output` hook
     *
     * Hook for post-processing of page content before output
     *
     * @see TypoScriptFrontendController::processOutput
     */
    private function registerOnBeforeOutput()
    {
        if (0 === count($this->beforeOutputProcessors)) {
            return;
        }

        $path = 'TYPO3_CONF_VARS|SC_OPTIONS|tslib/class.tslib_fe.php|contentPostProc-output';
        $value = sprintf('%s->%s', __CLASS__, 'executeOnBeforeOutputPostProcessors');

        $this->pushToGlobalArrayByArrayPath($path, $value);
    }

    public function executeOnStartPostProcessors(array &$parameters, TypoScriptFrontendController &$controller)
    {
        $controllerAdapter = new ControllerAdapter($controller);

        array_walk(
            $this->startProcessors,
            function (ContentPostProcessorInterface $processor) use ($controllerAdapter) {
                $processor->modify($controllerAdapter);
            }
        );

        $controller = $controllerAdapter->getController();
    }

    public function executeOnBeforeCachePostProcessors(array &$parameters, TypoScriptFrontendController &$controller)
    {
        $controllerAdapter = new ControllerAdapter($controller);

        array_walk(
            $this->beforeCacheProcessors,
            function (ContentPostProcessorInterface $processor) use ($controllerAdapter) {
                $processor->modify($controllerAdapter);
            }
        );

        $controller = $controllerAdapter->getController();
    }

    public function executeOnBeforeOutputPostProcessors(array &$parameters, TypoScriptFrontendController &$controller)
    {
        $controllerAdapter = new ControllerAdapter($controller);

        array_walk(
            $this->beforeOutputProcessors,
            function (ContentPostProcessorInterface $processor) use ($controllerAdapter) {
                $processor->modify($controllerAdapter);
            }
        );

        $controller = $controllerAdapter->getController();
    }
}
