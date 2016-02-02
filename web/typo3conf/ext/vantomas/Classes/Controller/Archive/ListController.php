<?php
namespace DreadLabs\Vantomas\Controller\Archive;

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

use DreadLabs\VantomasWebsite\Archive\DateRepositoryInterface;
use DreadLabs\VantomasWebsite\Page\Type;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * ListController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ListController extends ActionController
{

    /**
     * Date repository, used for list action
     *
     * @var DateRepositoryInterface
     */
    protected $dateRepository;

    /**
     * Injects the date repository
     *
     * @param DateRepositoryInterface $dateRepository DateRepository impl
     *
     * @return void
     */
    public function injectDateRepository(DateRepositoryInterface $dateRepository)
    {
        $this->dateRepository = $dateRepository;
    }

    /**
     * Archive listing
     *
     * @return void
     */
    public function showAction()
    {
        $dates = $this
            ->dateRepository
            ->findByPageType(Type::fromString($this->settings['pageType']));

        $this->view->assign('dates', $dates);
    }
}
