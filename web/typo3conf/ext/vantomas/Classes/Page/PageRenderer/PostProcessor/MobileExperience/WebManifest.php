<?php
namespace DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\MobileExperience;

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
 * WebManifest
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class WebManifest implements HookInterface, FrontendInterface
{

    /**
     * @var int
     */
    private $pageObjectTypeNum;

    /**
     * @var array
     */
    private $linkTagAttributes = [
        'rel' => 'manifest',
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
     * @param int $pageObjectTypeNum
     */
    public function __construct($pageObjectTypeNum)
    {
        if (is_int($pageObjectTypeNum)) {
            $this->pageObjectTypeNum = $pageObjectTypeNum;
        }
    }

    /**
     * Sets the frontend controller to allow context-specific operations with it.
     *
     * @param TypoScriptFrontendController $controller
     *
     * @return void
     */
    public function setController(TypoScriptFrontendController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Modifies the PageRenderer
     *
     * @param PageRendererAdapter $pageRenderer
     */
    public function modify(PageRendererAdapter $pageRenderer)
    {
        if (!$this->isApplicable()) {
            return;
        }

        $this->buildLinkTag();

        $pageRenderer->addMetaTag($this->linkTag);
    }

    private function isApplicable()
    {
        return !is_null($this->controller);
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
            $this->controller->cObj->getData('leveluid:0'),
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
