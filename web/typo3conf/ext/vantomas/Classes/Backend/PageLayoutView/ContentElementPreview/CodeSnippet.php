<?php
namespace DreadLabs\Vantomas\Backend\PageLayoutView\ContentElementPreview;

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

use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * CodeSnippet
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class CodeSnippet implements PageLayoutViewDrawItemHookInterface
{

    /**
     * @var StandaloneView
     */
    private $view;

    /**
     * @var PageLayoutView
     */
    private $pageLayoutView;

    /**
     * @var string
     */
    private $headerContent;

    /**
     * @var string
     */
    private $itemContent;

    /**
     * @var array
     */
    private $row = [];

    /**
     * Pre-processes the preview rendering of a content element.
     *
     * @param PageLayoutView $pageLayoutView Calling parent object
     * @param bool $drawItem Whether to draw the item using the default functionalities
     * @param string $headerContent Header content
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     *
     * @return void
     */
    public function preProcess(PageLayoutView &$pageLayoutView, &$drawItem, &$headerContent, &$itemContent, array &$row)
    {
        $this->pageLayoutView = $pageLayoutView;
        $this->headerContent = $headerContent;
        $this->itemContent = $itemContent;
        $this->row = $row;

        if (!$this->canRender()) {
            return;
        }

        $this->initialize();

        $drawItem = false;

        $this->renderHeader();
        $this->renderContent();

        $pageLayoutView = $this->pageLayoutView;
        $headerContent = $this->headerContent;
        $itemContent = $this->itemContent;
        $row = $this->row;
    }

    /**
     * Flags if the incoming row can be rendered by the DrawItem
     *
     * @return bool
     */
    private function canRender()
    {
        return 'vantomas_codesnippet' === $this->row['CType'];
    }

    private function initialize()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->view = $objectManager->get(StandaloneView::class);
        $this->view->setTemplatePathAndFilename($this->getViewTemplatePathAndFilename());
    }

    /**
     * @return string
     */
    private function getViewTemplatePathAndFilename()
    {
        return GeneralUtility::getFileAbsFileName(
            'EXT:vantomas/Resources/Private/Templates/Backend/PageLayoutView/Preview/ContentElement/CodeSnippet.html'
        );
    }

    /**
     * Renders the header preview of a content element.
     *
     * @return void
     */
    private function renderHeader()
    {
        $this->view->assign('section', 'headerContent');

        $this->view->assign('headerContent', $this->headerContent);

        $this->headerContent = $this->view->render();
    }

    /**
     * Renders the content preview of a content element.
     *
     * @return void
     */
    private function renderContent()
    {
        $this->view->assign('section', 'itemContent');

        $this->view->assign('uid', $this->row['uid']);
        $this->view->assign('code', $this->row['bodytext']);
        $this->view->assign('label', $this->row['subheader']);

        $this->itemContent .= $this->view->render();
    }
}
