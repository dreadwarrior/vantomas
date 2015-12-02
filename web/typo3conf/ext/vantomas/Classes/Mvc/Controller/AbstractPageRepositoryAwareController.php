<?php
namespace DreadLabs\Vantomas\Mvc\Controller;

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

use DreadLabs\VantomasWebsite\Page\PageRepositoryInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * AbstractPageRepositoryAwareController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
abstract class AbstractPageRepositoryAwareController extends ActionController implements PageRepositoryAwareControllerInterface
{

    /**
     * Page repository
     *
     * @var PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * Injects the page repository into the controller
     *
     * @param PageRepositoryInterface $pageRepository PageRepository implementation
     *
     * @return void
     */
    public function injectPageRepository(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }
}
