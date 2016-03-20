<?php
namespace DreadLabs\Vantomas\Hook\PageLayoutView;

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

use DreadLabs\Vantomas\Backend\PageLayoutView\PluginPreviewInterface;
use DreadLabs\Vantomas\Utility\ArrayUtilityTrait;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * PreviewHookRegistry
 *
 * Registers tt_content_drawItem and list_type_Info preview handlers.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PreviewHookRegistry implements SingletonInterface
{
    use ArrayUtilityTrait;

    /**
     * @var PageLayoutViewDrawItemHookInterface[]
     */
    private $contentElements = [];

    /**
     * @var PluginPreviewInterface[]
     */
    private $plugins = [];

    /**
     * @param string $handlerClassName
     *
     * @return PreviewHookRegistry
     */
    public function addHandler($handlerClassName)
    {
        $previewHandler = GeneralUtility::makeInstance($handlerClassName);

        if ($previewHandler instanceof PageLayoutViewDrawItemHookInterface) {
            array_push($this->contentElements, $previewHandler);

            return $this;
        }

        if ($previewHandler instanceof PluginPreviewInterface) {
            array_push($this->plugins, $previewHandler);

            return $this;
        }

        throw new \InvalidArgumentException(
            sprintf(
                'The given preview handler class %s must implement either one of PageLayoutViewDrawItemHookInterface or PluginPreviewInterface.',
                $handlerClassName
            ),
            1458480978376
        );
    }

    public function register()
    {
        if (count($this->contentElements) > 0) {
            $this->registerContentElements();
        }
        if (count($this->plugins) > 0) {
            $this->registerPlugins();
        }
    }

    private function registerContentElements()
    {
        $path = 'TYPO3_CONF_VARS|SC_OPTIONS|cms/layout/class.tx_cms_layout.php|tt_content_drawItem';

        array_walk($this->contentElements, function (PageLayoutViewDrawItemHookInterface $contentElement) use ($path) {
            $this->pushToGlobalArrayByArrayPath($path, get_class($contentElement));
        });
    }

    private function registerPlugins()
    {
        $path = 'TYPO3_CONF_VARS|SC_OPTIONS|cms/layout/class.tx_cms_layout.php|list_type_Info';

        array_walk($this->plugins, function (PluginPreviewInterface $plugin) use ($path) {
            $this->pushToGlobalArrayByArrayPath(
                sprintf('%s|%s', $path, $plugin->getSignature()),
                sprintf('%s->%s', get_class($plugin), 'renderPluginInfo')
            );
        });
    }
}
