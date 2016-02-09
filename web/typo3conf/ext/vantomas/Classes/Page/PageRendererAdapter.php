<?php
namespace DreadLabs\Vantomas\Page;

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

use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * PageRendererAdapter
 *
 * Wraps the TYPO3.CMS core PageRenderer and allows modifications of
 * it via a streamlined API for the use cases of this project.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class PageRendererAdapter
{

    /**
     * @var PageRenderer
     */
    private $pageRenderer;

    /**
     * @var array
     */
    private $parameters;

    public function __construct(PageRenderer $pageRenderer, array $parameters)
    {
        $this->pageRenderer = $pageRenderer;
        $this->parameters = $parameters;
    }

    /**
     * @return PageRenderer
     */
    public function getPageRenderer()
    {
        return $this->pageRenderer;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $metaTag
     */
    public function addMetaTag($metaTag)
    {
        $this->pageRenderer->addMetaTag($metaTag);
    }

    /**
     * @param string $headTag
     */
    public function setHeadTag($headTag)
    {
        $this->pageRenderer->setHeadTag($headTag);
    }

    /**
     * @param string $titleTag
     */
    public function setTitleTag($titleTag)
    {
        $this->parameters['titleTag'] = (string) $titleTag;
    }
}
