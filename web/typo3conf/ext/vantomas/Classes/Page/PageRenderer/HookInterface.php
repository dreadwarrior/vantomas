<?php
namespace DreadLabs\Vantomas\Page\PageRenderer;

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

use DreadLabs\Vantomas\Page\PageRendererAdapter;

/**
 * HookInterface
 *
 * API for PageRenderer hook implementations to allow modifications
 * of the PageRenderer.
 *
 * @see \DreadLabs\Vantomas\Page\PageRenderer\HookContext\BackendInterface
 * @see \DreadLabs\Vantomas\Page\PageRenderer\HookContext\FrontendInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface HookInterface
{

    /**
     * Modifies the PageRenderer
     *
     * @param PageRendererAdapter $pageRenderer
     */
    public function modify(PageRendererAdapter $pageRenderer);
}
