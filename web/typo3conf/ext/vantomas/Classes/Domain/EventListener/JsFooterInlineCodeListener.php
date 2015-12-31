<?php
namespace DreadLabs\Vantomas\Domain\EventListener;

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

use DreadLabs\Vantomas\Mvc\Controller\PageAssetControllerInterface;
use DreadLabs\VantomasWebsite\EventListener\AbstractAddPageAssetListener;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Mvc\Response;

/**
 * JsFooterInlineCodeListener
 *
 * The PageRenderer::add*() arguments may be specified by
 * setting an appropriate request argument in the controller:
 *
 * <code>
 * $this->request->setArgument('compress', false);
 * $this->request->setArgument('forceOnTop', false);
 * </code>
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class JsFooterInlineCodeListener extends AbstractAddPageAssetListener
{

    /**
     * @var PageRenderer
     */
    private $pageRenderer;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param PageRenderer $pageRenderer
     */
    public function __construct(
        PageRenderer $pageRenderer
    ) {
        $this->pageRenderer = $pageRenderer;
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return array
     */
    public function handle(Request $request, Response $response)
    {
        $this->request = $request;

        if (!$this->isResponsible()) {
            return array($request, $response);
        }

        $this->pageRenderer->addJsFooterInlineCode(
            $request->getControllerName(),
            $response->getContent(),
            $request->hasArgument('compress') ? (bool) $request->getArgument('compress') : false,
            $request->hasArgument('forceOnTop') ? (bool) $request->getArgument('forceOnTop') : false
        );

        $response->setContent('');

        return array($request, $response);
    }

    /**
     * @return bool
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchControllerException
     */
    protected function isResponsible()
    {
        $implementsInterface = in_array(
            PageAssetControllerInterface::class,
            class_implements($this->request->getControllerObjectName())
        );

        $isCoherentAction = 'jsFooterInline' === $this->request->getControllerActionName();

        return $implementsInterface && $isCoherentAction;
    }
}
