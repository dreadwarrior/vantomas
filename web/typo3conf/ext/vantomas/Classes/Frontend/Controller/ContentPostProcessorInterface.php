<?php
namespace DreadLabs\Vantomas\Frontend\Controller;

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

use DreadLabs\Vantomas\Frontend\ControllerAdapter;

/**
 * ContentPostProcessorInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface ContentPostProcessorInterface
{

    /**
     * @param ControllerAdapter $controller
     *
     * @return void
     */
    public function modify(ControllerAdapter $controller);
}
