<?php
namespace DreadLabs\Vantomas\Controller\Content;

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

use DreadLabs\Vantomas\Domain\Repository\CodeSnippetRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * CodeSnippetController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class CodeSnippetController extends ActionController
{
    /**
     * @var CodeSnippetRepository
     */
    private $codeSnippetRepository;

    /**
     * @param CodeSnippetRepository $repository
     *
     * @return void
     */
    public function injectCodeSnippetRepository(CodeSnippetRepository $repository)
    {
        $this->codeSnippetRepository = $repository;
    }

    public function showAction()
    {
        $snippetUid = $this->configurationManager->getContentObject()->data['uid'];

        $snippet = $this->codeSnippetRepository->findByUid($snippetUid);

        $this->view->assign('snippet', $snippet);
    }
}
