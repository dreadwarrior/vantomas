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
 * BlogArticleJsonLdLink
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class BlogArticleJsonLdLink extends AbstractFrontendPostProcessor implements PostProcessorInterface
{

    /**
     * @const int
     */
    const DOKTYPE = 30;

    /**
     * @const int
     */
    const PAGE_TYPE = 1453488849009;

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

        $this->modifyMetaTags();

        $parameters = $this->parameters;
    }

    protected function canRender()
    {
        if (!parent::canRender()) {
            return false;
        }

        $isValidDoktype = self::DOKTYPE === (int) $this->pageContentObjectRenderer->data['doktype'];

        return $isValidDoktype;
    }

    private function modifyMetaTags()
    {
        $uri = $this->getTypolinkUri($this->pageContentObjectRenderer->data['uid'], self::PAGE_TYPE);
        $link = sprintf(
            '<link rel="alternate" type="application/ld+json" href="%s">',
            $uri
        );

        array_push($this->parameters['metaTags'], $link);
    }

    /**
     * @param int $pageUid
     * @param int $pageType
     *
     * @return string
     */
    private function getTypolinkUri($pageUid, $pageType)
    {
        $parameter = sprintf('%s,%s', (int) $pageUid, $pageType);

        return $this->pageContentObjectRenderer->typoLink_URL(
            [
                'parameter' => $parameter,
            ]
        );
    }
}
