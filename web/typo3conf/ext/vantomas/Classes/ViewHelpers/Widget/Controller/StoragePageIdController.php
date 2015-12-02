<?php
namespace DreadLabs\Vantomas\ViewHelpers\Widget\Controller;

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

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;

/**
 * StoragePageIdController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class StoragePageIdController extends AbstractWidgetController
{

    /**
     * Renders the widget
     *
     * @return void
     */
    public function indexAction()
    {
        $storagePageId = (int) $this->configurationManager->getContentObject()->data['pages'];

        $this->view->assign('storagePageId', $storagePageId);
    }
}
