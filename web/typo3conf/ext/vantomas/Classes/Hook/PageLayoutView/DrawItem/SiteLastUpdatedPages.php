<?php
namespace DreadLabs\Vantomas\Hook\PageLayoutView\DrawItem;

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

use DreadLabs\Vantomas\Domain\Repository\PageRepository;
use DreadLabs\Vantomas\Hook\PageLayoutView\AbstractDrawItem;
use DreadLabs\VantomasWebsite\Page\RepositoryInterface;
use DreadLabs\VantomasWebsite\Page\Type;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * SiteLastUpdatedPages
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SiteLastUpdatedPages extends AbstractDrawItem
{

    /**
     * ViewInterface
     *
     * @var ViewInterface
     */
    protected $view;

    /**
     * @var RepositoryInterface
     */
    protected $pageRepository;

    /**
     * Flags if the incoming row can be rendered by the DrawItem
     *
     * @param array $row The incoming tt_content row to analyze
     *
     * @return bool
     */
    public function canRender(array $row)
    {
        $assertContentType = 'list' === $row['CType'];
        $assertPlugin = 'vantomas_sitelastupdatedpages' === $row['list_type'];

        return $assertContentType && $assertPlugin;
    }

    /**
     * Initializes the DrawItem
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->view = $this->objectManager->get(StandaloneView::class);
        $this->view->setTemplatePathAndFilename(
            GeneralUtility::getFileAbsFileName(
                'EXT:vantomas/Resources/Private/Templates/DrawItem/SiteLastUpdatedPages.html'
            )
        );

        $this->pageRepository = $this->objectManager->get(PageRepository::class);
    }

    /**
     * Renders the header preview of a content element.
     *
     * The initial header content is passed as a reference like in the core's
     * PageLayoutViewDrawItemHookInterface. The implementation has to modify
     * the content.
     *
     * @param PageLayoutView $parentObject Calling parent object
     * @param string $headerContent Header content
     * @param array $row Record row of tt_content
     *
     * @return void
     */
    public function renderHeader(PageLayoutView &$parentObject, &$headerContent, array &$row)
    {
        $this->view->assign('section', 'headerContent');

        $this->view->assign('headerContent', $headerContent);

        $headerContent = $this->view->render();
    }

    /**
     * Renders the content preview of a content element.
     *
     * The initial item content is passed as a reference like in the core's
     * PageLayoutViewDrawItemHookInterface. The implementation has to modify
     * the content.
     *
     * @param PageLayoutView $parentObject Calling parent object
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     *
     * @return void
     */
    public function renderContent(PageLayoutView &$parentObject, &$itemContent, array &$row)
    {
        $this->view->assign('section', 'itemContent');

        $pageType = Type::fromString($this->getFlexformValue($row['pi_flexform'], 'settings.pageType'));
        $offset = (int) $this->getFlexformValue($row['pi_flexform'], 'settings.offset');
        $limit = (int) $this->getFlexformValue($row['pi_flexform'], 'settings.limit');

        $this->view->assign('typeLabelReference', $this->getPageTypeLabelReference($pageType));
        $this->view->assign('offset', $offset);
        $this->view->assign('limit', $limit);

        $pages = $this
            ->pageRepository
            ->findLastUpdated($pageType, $offset - 1, $limit);

        $this->view->assign('pages', $pages);

        $itemContent .= $this->view->render();
    }

    /**
     * Returns the page type label reference for the configured page type.
     *
     * @param Type $pageType Set page type
     *
     * @return string
     */
    private function getPageTypeLabelReference(Type $pageType)
    {
        $registeredTypes = ArrayUtility::getValueByPath($GLOBALS, 'TCA/pages/columns/doktype/config/items');

        $typeConfigurations = array_filter($registeredTypes, function ($configuration) use ($pageType) {
            return (int) $configuration[1] === $pageType->getValue();
        });

        $typeConfiguration = array_shift($typeConfigurations);

        return array_shift($typeConfiguration);
    }
}
