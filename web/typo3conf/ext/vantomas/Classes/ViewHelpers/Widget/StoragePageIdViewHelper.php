<?php
namespace DreadLabs\Vantomas\ViewHelpers\Widget;

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

use DreadLabs\Vantomas\ViewHelpers\Widget\Controller\StoragePageIdController;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;
use TYPO3\CMS\Fluid\Core\Widget\Exception\MissingControllerException;

/**
 * StoragePageIdViewHelper
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class StoragePageIdViewHelper extends AbstractWidgetViewHelper
{

    /**
     * The widget controller
     *
     * @var StoragePageIdController
     */
    protected $controller;

    /**
     * Injects the widget controller
     *
     * @param StoragePageIdController $controller The widget controller
     *
     * @return void
     */
    public function injectController(StoragePageIdController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Renders the view helper
     *
     * @return \TYPO3\CMS\Extbase\Mvc\ResponseInterface
     *
     * @throws MissingControllerException If widget has no controller
     */
    public function render()
    {
        return $this->initiateSubRequest();
    }
}
