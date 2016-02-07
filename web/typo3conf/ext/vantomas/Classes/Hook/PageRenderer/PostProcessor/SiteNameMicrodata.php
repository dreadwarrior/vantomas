<?php
namespace DreadLabs\Vantomas\Hook\PageRenderer\PostProcessor;

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

use DreadLabs\Vantomas\Hook\PageRenderer\AbstractFrontendPostProcessor;
use DreadLabs\Vantomas\Hook\PageRenderer\PostProcessorInterface;
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * SiteNameMicrodata
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SiteNameMicrodata extends AbstractFrontendPostProcessor implements PostProcessorInterface
{

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var PageRenderer
     */
    private $pageRenderer;

    public function render(array &$parameters, PageRenderer &$pageRenderer)
    {
        if (!$this->canRender()) {
            return;
        }

        $this->parameters = $parameters;
        $this->pageRenderer = $pageRenderer;

        $this->modifyHeadTag();
        $this->modifyTitleTag();
        $this->addCanonicalLink();

        $parameters = $this->parameters;
    }

    protected function canRender()
    {
        if (!parent::canRender()) {
            return false;
        }

        $isHomepage = 0 === $this->pageContentObjectRenderer->getData('level');

        return $isHomepage;
    }

    private function modifyHeadTag()
    {
        $this->parameters['headTag'] = '<head itemscope itemtype="http://schema.org/WebSite">';
    }

    private function modifyTitleTag()
    {
        $this->parameters['titleTag'] = '<title itemprop="name">|</title>';
    }

    private function addCanonicalLink()
    {
        $uri = $this->pageContentObjectRenderer->getData('getIndpEnv:TYPO3_REQUEST_HOST');
        $link = sprintf('<link rel="canonical" href="%s/" itemprop="url">', $uri);

        array_push($this->parameters['metaTags'], $link);
    }
}
