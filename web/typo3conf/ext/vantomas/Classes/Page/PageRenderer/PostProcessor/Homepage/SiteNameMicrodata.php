<?php
namespace DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\Homepage;

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

use DreadLabs\Vantomas\Page\PageRenderer\HookContext\FrontendInterface;
use DreadLabs\Vantomas\Page\PageRenderer\HookInterface;
use DreadLabs\Vantomas\Page\PageRendererAdapter;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * SiteNameMicrodata
 *
 * Modifies the <head /> and <title /> tag and build and appends a
 * <link /> meta tag with an "canonical" relationship to the site
 * domain to annotate the site name in search results.
 *
 * @see https://developers.google.com/structured-data/site-name
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SiteNameMicrodata implements HookInterface, FrontendInterface
{

    /**
     * @var array
     */
    private $linkTagAttributes = [
        'rel' => 'canonical',
        'itemprop' => 'url',
    ];

    /**
     * @var TypoScriptFrontendController
     */
    private $controller;

    /**
     * @var string
     */
    private $headTag = '<head itemscope itemtype="http://schema.org/WebSite">';

    /**
     * @var string
     */
    private $titleTag = '<title itemprop="name">|</title>';

    /**
     * @var string
     */
    private $linkTag;

    public function setController(TypoScriptFrontendController $controller)
    {
        $this->controller = $controller;
    }

    public function modify(PageRendererAdapter $pageRenderer)
    {
        if (!$this->isApplicable()) {
            return;
        }

        $pageRenderer->setHeadTag($this->headTag);
        $pageRenderer->setTitleTag($this->titleTag);

        $this->buildLinkTag();

        $pageRenderer->addMetaTag($this->linkTag);
    }

    /**
     * @return bool
     */
    private function isApplicable()
    {
        if (is_null($this->controller)) {
            return false;
        }

        return 0 === (int) $this->controller->cObj->getData('level');
    }

    private function buildLinkTag()
    {
        $this->setHrefAttribute();

        $attributes = array_reduce(array_keys($this->linkTagAttributes), array($this, 'serializeTagAttributes'), '');

        $this->linkTag = sprintf('<link%s>', $attributes);
    }

    private function setHrefAttribute()
    {
        $uri = $this->controller->cObj->getData('getIndpEnv:TYPO3_REQUEST_HOST') . '/';

        $this->linkTagAttributes['href'] = $uri;
    }

    /**
     * @param string $serializedAttributes
     * @param string $attributeKey
     *
     * @return string
     */
    private function serializeTagAttributes($serializedAttributes, $attributeKey)
    {
        $serializedAttributes .= sprintf(' %s="%s"', $attributeKey, $this->linkTagAttributes[$attributeKey]);

        return $serializedAttributes;
    }
}
