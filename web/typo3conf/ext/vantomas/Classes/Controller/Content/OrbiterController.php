<?php
namespace DreadLabs\Vantomas\Controller\Content;

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

use DreadLabs\Vantomas\Domain\Repository\OrbiterRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * OrbiterController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class OrbiterController extends ActionController
{

    /**
     * OrbiterRepository
     *
     * @var OrbiterRepository
     */
    private $orbiterRepository;

    /**
     * InjectOrbiterRepository
     *
     * @param OrbiterRepository $orbiterRepository OrbiterRepository
     *
     * @return void
     */
    public function injectOrbiterRepository(OrbiterRepository $orbiterRepository)
    {
        $this->orbiterRepository = $orbiterRepository;
    }

    /**
     * Shows the orbiter
     *
     * @return void
     */
    public function showAction()
    {
        $orbiterUid = $this->configurationManager->getContentObject()->data['uid'];

        $orbiter = $this->orbiterRepository->findByUid($orbiterUid);

        $this->view->assign('orbiter', $orbiter);
    }
}
