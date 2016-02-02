<?php
namespace DreadLabs\Vantomas\Controller\Site;

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

use DreadLabs\Vantomas\Mvc\Controller\AbstractPageRepositoryAwareController;
use DreadLabs\VantomasWebsite\Page\Type;

/**
 * LastUpdatedPagesController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class LastUpdatedPagesController extends AbstractPageRepositoryAwareController
{

    /**
     * Lists last updated pages
     *
     * @return void
     */
    public function listAction()
    {
        $pageType = Type::fromString($this->settings['pageType']);
        $offset = (int) $this->settings['offset'];
        $limit = (int) $this->settings['limit'];

        $pages = $this
            ->pageRepository
            ->findLastUpdated($pageType, $offset - 1, $limit);

        $this->view->assign('pages', $pages);
    }
}
