<?php
namespace DreadLabs\Vantomas\Controller\Taxonomy;

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

use DreadLabs\VantomasWebsite\Taxonomy\TagManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * TagCloudController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TagCloudController extends ActionController
{

    /**
     * TagManager provides an API for tag / tag cloud specific queries
     *
     * @var TagManagerInterface
     */
    private $tagManager;

    /**
     * Injects the TagManager impl
     *
     * @param TagManagerInterface $tagManager TagManager impl
     *
     * @return void
     */
    public function injectTagManager(TagManagerInterface $tagManager)
    {
        $this->tagManager = $tagManager;
    }

    /**
     * Generates a tag cloud
     *
     * @return void
     */
    public function showAction()
    {
        $cloud = $this->tagManager->getCloud();
        $this->view->assign('cloud', $cloud);
    }
}
