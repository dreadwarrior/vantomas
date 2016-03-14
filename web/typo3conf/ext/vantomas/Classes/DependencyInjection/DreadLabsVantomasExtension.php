<?php
namespace DreadLabs\Vantomas\DependencyInjection;

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

use DreadLabs\Vantomas\Controller\Form\ContactController;
use DreadLabs\Vantomas\Domain\EventListener\JsFooterInlineCodeListener;
use DreadLabs\Vantomas\Domain\EventListener\PersistSecretSantaPairListener;
use DreadLabs\Vantomas\Domain\EventListener\RegisterSyntaxHighlighterBrushListener;
use DreadLabs\Vantomas\Domain\Page\Typo3PagesFactory;
use DreadLabs\Vantomas\Domain\TeaserImage\FilesContentObjectResourceFactory;
use DreadLabs\Vantomas\Domain\TeaserImage\FoldedPaperWithGrungeCanvasFactory;
use DreadLabs\Vantomas\Domain\TeaserImage\GifbuilderCanvas;
use DreadLabs\VantomasWebsite\CodeSnippet\SyntaxHighlighterParser;
use DreadLabs\VantomasWebsite\Http\ClientInterface;
use DreadLabs\VantomasWebsite\Http\NetHttpAdapter\Client;
use DreadLabs\VantomasWebsite\Mail\Carrier;
use DreadLabs\VantomasWebsite\Page\FactoryInterface;
use DreadLabs\VantomasWebsite\SecretSanta\Donee\Resolver;
use DreadLabs\VantomasWebsite\TeaserImage\CanvasFactoryInterface;
use DreadLabs\VantomasWebsite\TeaserImage\CanvasInterface;
use DreadLabs\VantomasWebsite\TeaserImage\ResourceFactoryInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Mvc\Dispatcher as RequestDispatcher;
use TYPO3\CMS\Extbase\Object\Container\Container;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * DreadLabsVantomasExtension
 *
 * Namespace, class naming and method signatures (except static declarations
 * and arguments) curries with Symfony DI API.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class DreadLabsVantomasExtension implements SingletonInterface
{

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(Container $container, Dispatcher $dispatcher)
    {
        $this->container = $container;
        $this->dispatcher = $dispatcher;
    }

    public function load()
    {
        $this->registerImplementations();
        $this->registerEventListeners();
    }

    /**
     * Early registration of interface implementations
     */
    private function registerImplementations()
    {
        // NOTE: this is necessary in FLUIDTEMPLATE based PAGE rendering contexts
        // @see: https://forge.typo3.org/issues/50788
        $this->container->registerImplementation(
            CanvasFactoryInterface::class,
            FoldedPaperWithGrungeCanvasFactory::class
        );
        $this->container->registerImplementation(
            CanvasInterface::class,
            GifbuilderCanvas::class
        );
        $this->container->registerImplementation(
            ResourceFactoryInterface::class,
            FilesContentObjectResourceFactory::class
        );
        // @NOTE: necessary for the FrontendAuthentication service (ReCaptcha)
        $this->container->registerImplementation(
            ClientInterface::class,
            Client::class
        );
        $this->container->registerImplementation(
            FactoryInterface::class,
            Typo3PagesFactory::class
        );
    }

    private function registerEventListeners()
    {
        // -- register contact form mailing handler
        $this->dispatcher->connect(
            ContactController::class,
            'send',
            Carrier::class,
            'convey'
        );

        // -- register secret santa donor/donee pair persister
        $this->dispatcher->connect(
            Resolver::class,
            'FoundDonee',
            PersistSecretSantaPairListener::class,
            'handle'
        );

        // -- register code snippet brush registration
        $this->dispatcher->connect(
            SyntaxHighlighterParser::class,
            'RegisterCodeSnippetBrush',
            RegisterSyntaxHighlighterBrushListener::class,
            'handle'
        );

        // -- register dispatcher slot for deferred loading of code snippet page assets
        $this->dispatcher->connect(
            RequestDispatcher::class,
            'afterRequestDispatch',
            JsFooterInlineCodeListener::class,
            'handle'
        );
    }
}
