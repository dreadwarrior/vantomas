<?php
namespace DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\Article;

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
use DreadLabs\Vantomas\Page\PageType;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * JsonLdLink
 *
 * Builds and appends a <link /> meta tag with an "alternate" relationship
 * to the JSON-LD representation of a blog article.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class JsonLdLink implements HookInterface, FrontendInterface
{

    /**
     * @var int
     */
    private $pageObjectTypeNum = 0;

    /**
     * @var array
     */
    private $linkTagAttributes = [
        'rel' => 'alternate',
        'type' => 'application/ld+json',
    ];

    /**
     * @var TypoScriptFrontendController
     */
    private $controller;

    /**
     * @var string
     */
    private $linkTag;

    /**
     * @param int $pageObjectTypeNum TypoScript `PAGE.typeNum`, defaults to 0 if no integer is given.
     */
    public function __construct($pageObjectTypeNum)
    {
        if (is_int($pageObjectTypeNum)) {
            $this->pageObjectTypeNum = $pageObjectTypeNum;
        }
    }

    public function setController(TypoScriptFrontendController $controller)
    {
        $this->controller = $controller;
    }

    public function modify(PageRendererAdapter $pageRenderer)
    {
        if (!$this->isApplicable()) {
            return;
        }

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

        return PageType::BLOG_ARTICLE === (int) $this->controller->cObj->getData('field:doktype');
    }

    private function buildLinkTag()
    {
        $this->setHrefAttribute();

        $attributes = array_reduce(array_keys($this->linkTagAttributes), array($this, 'serializeTagAttributes'), '');

        $this->linkTag = sprintf('<link%s>', $attributes);
    }

    private function setHrefAttribute()
    {
        $parameter = sprintf(
            '%s,%s',
            $this->controller->cObj->getData('field:uid'),
            $this->pageObjectTypeNum
        );

        $uri = $this->controller->cObj->typoLink_URL(
            [
                'parameter' => $parameter,
            ]
        );

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
