<?php
namespace DreadLabs\Vantomas\Backend\PageLayoutView;

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

use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * PluginPreviewInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface PluginPreviewInterface extends SingletonInterface
{

    /**
     * @return string
     */
    public function getSignature();

    /**
     * @param array $parameters Associative array, containing the keys:
     *                          - &pObj = PageLayoutView
     *                          - row = tt_content row
     *                          - infoArr = array with information (???)
     * @param PageLayoutView $pageLayoutView
     *
     * @return string Rendered information
     */
    public function renderPluginInfo(array &$parameters, PageLayoutView &$pageLayoutView);
}
