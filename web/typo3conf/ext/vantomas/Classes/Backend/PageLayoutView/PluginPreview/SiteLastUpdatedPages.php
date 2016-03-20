<?php
namespace DreadLabs\Vantomas\Backend\PageLayoutView\PluginPreview;

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

use DreadLabs\Vantomas\Backend\PageLayoutView\PluginPreviewInterface;
use DreadLabs\Vantomas\Domain\Repository\PageRepository;
use DreadLabs\VantomasWebsite\Page\RepositoryInterface;
use DreadLabs\VantomasWebsite\Page\Type;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * SiteLastUpdatedPages
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SiteLastUpdatedPages implements PluginPreviewInterface
{

    /**
     * @var StandaloneView
     */
    private $view;

    /**
     * @var RepositoryInterface
     */
    private $pageRepository;

    /**
     * @var array
     */
    private $row = [];

    /**
     * @var array
     */
    private $registeredPageDoktypes = [];

    /**
     * @return string
     */
    public function getSignature()
    {
        return 'vantomas_sitelastupdatedpages';
    }

    /**
     * @param array $parameters Associative array, containing the keys:
     *                          - &pObj = PageLayoutView
     *                          - row = tt_content row
     *                          - infoArr = array with information (???)
     * @param PageLayoutView $pageLayoutView
     *
     * @return string Rendered information
     */
    public function renderPluginInfo(array &$parameters, PageLayoutView &$pageLayoutView)
    {
        $this->initialize();

        $this->row = $parameters['row'];

        $this->view->assign('section', 'itemContent');

        $pageType = Type::fromString(
            $this->getFlexformValue(
                $this->row['pi_flexform'],
                'settings.pageType'
            )
        );
        $offset = (int) $this->getFlexformValue($this->row['pi_flexform'], 'settings.offset');
        $limit = (int) $this->getFlexformValue($this->row['pi_flexform'], 'settings.limit');

        $this->view->assign('typeLabelReference', $this->getPageTypeLabelReference($pageType));
        $this->view->assign('offset', $offset);
        $this->view->assign('limit', $limit);

        $pages = $this
            ->pageRepository
            ->findLastUpdated($pageType, $offset - 1, $limit);

        $this->view->assign('pages', $pages);

        return $this->view->render();
    }

    private function initialize()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->view = $objectManager->get(StandaloneView::class);
        $this->view->setTemplatePathAndFilename($this->getViewTemplatePathAndFilename());

        $this->pageRepository = $objectManager->get(PageRepository::class);
    }

    /**
     * @return string
     */
    public function getViewTemplatePathAndFilename()
    {
        return GeneralUtility::getFileAbsFileName(
            'EXT:vantomas/Resources/Private/Templates/Backend/PageLayoutView/Preview/Plugin/SiteLastUpdatedPages.html'
        );
    }

    /**
     * Returns a value from the given flexform xml string
     *
     * @param string $xml The flexform XML string
     * @param string $field The field in question
     *
     * @return mixed|string
     */
    protected function getFlexformValue($xml, $field)
    {
        try {
            $data = GeneralUtility::xml2array($xml);
            $value = ArrayUtility::getValueByPath($data, 'data/sDEF/lDEF/' . $field . '/vDEF');

            return $value !== $data ? $value : 'N/A';
        } catch (\Exception $exc) {
            return 'N/A';
        }
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
        $this->registeredPageDoktypes = ArrayUtility::getValueByPath(
            $GLOBALS,
            'TCA/pages/columns/doktype/config/items'
        );

        $typeConfigurations = array_filter($this->registeredPageDoktypes, function ($configuration) use ($pageType) {
            return (int) $configuration[1] === $pageType->getValue();
        });

        $typeConfiguration = array_shift($typeConfigurations);

        return array_shift($typeConfiguration);
    }
}
