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

use DreadLabs\Vantomas\Hook\PageLayoutView\AbstractDrawItem;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * CodeSnippet
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class CodeSnippet extends AbstractDrawItem
{

    /**
     * ViewInterface
     *
     * @var ViewInterface
     */
    protected $view;

    /**
     * Flags if the incoming row can be rendered by the DrawItem
     *
     * @param array $row The incoming tt_content row to analyze
     *
     * @return bool
     */
    public function canRender(array $row)
    {
        $assertContentType = 'vantomas_codesnippet' === $row['CType'];

        return $assertContentType;
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
                'EXT:vantomas/Resources/Private/Templates/DrawItem/CodeSnippet.html'
            )
        );
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

        $this->view->assign('uid', $row['uid']);
        $this->view->assign('code', $row['bodytext']);
        $this->view->assign('label', $row['subheader']);

        $itemContent .= $this->view->render();
    }
}
