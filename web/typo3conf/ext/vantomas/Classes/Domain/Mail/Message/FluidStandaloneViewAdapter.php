<?php
namespace DreadLabs\Vantomas\Domain\Mail\Message;

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

use DreadLabs\VantomasWebsite\Mail\MessageInterface;
use DreadLabs\VantomasWebsite\Mail\Message\ViewInterface;
use TYPO3\CMS\Install\View\StandaloneView;

/**
 * The mail message view adapter to the fluid template engine
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class FluidStandaloneViewAdapter implements ViewInterface
{

    /**
     * The view impl
     *
     * @var StandaloneView
     */
    private $view;

    /**
     * Constructor
     *
     * @param StandaloneView $view View impl
     */
    public function __construct(
        StandaloneView $view
    ) {
        $this->view = $view;
    }

    /**
     * Sets a template on the view
     *
     * @param string $template Path and filename to template
     *
     * @return void
     */
    public function setTemplate($template)
    {
        $this->view->setTemplatePathAndFilename($template);
    }

    /**
     * Sets template variables
     *
     * @param array $variables Template variables
     *
     * @return void
     */
    public function setVariables(array $variables)
    {
        $this->view->assignMultiple($variables);
    }

    /**
     * Renders the template on given message
     *
     * All view-centric parts of the message are set by calling
     * this method. Subject, Body (html/plain).
     *
     * @param MessageInterface $message Message to render into
     *
     * @return void
     */
    public function render(MessageInterface $message)
    {
        $message->setSubject($this->renderSection('Subject'));
        $message->setHtmlBody($this->renderSection('BodyHtml'));
        $message->setPlainBody($this->renderSection('BodyText'));
    }

    /**
     * Renders a specific section of the template
     *
     * This allows fine-grained modularization of the different
     * message parts (subject, plain/html body)
     *
     * @param string $section Name of the section to render
     *
     * @return string
     */
    private function renderSection($section)
    {
        $this->view->assign('Section', $section);

        return trim($this->view->render());
    }
}
