<?php
namespace DreadLabs\Vantomas\Page\PageRenderer\HookContext;

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

use TYPO3\CMS\Backend\Controller\BackendController;

/**
 * BackendInterface
 *
 * Provides the backend context on a hook. The hook then may receive the
 * backend controller via setter injection.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface BackendInterface
{

    /**
     * Sets the backend controller to allow context-specific operations with it.
     *
     * @param BackendController $controller
     *
     * @return void
     */
    public function setController(BackendController $controller);
}
