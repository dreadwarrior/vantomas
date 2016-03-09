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
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
class DreadLabsVantomasExtension
{

    public static function load()
    {
        $container = self::getContainer();

        self::registerImplementations($container);
        self::registerEventListeners();
    }

    /**
     * Early registration of interface implementations
     *
     * @param Container $container
     */
    private static function registerImplementations(Container $container)
    {
        // NOTE: this is necessary in FLUIDTEMPLATE based PAGE rendering contexts
        // @see: https://forge.typo3.org/issues/50788
        $container->registerImplementation(
            CanvasFactoryInterface::class,
            FoldedPaperWithGrungeCanvasFactory::class
        );
        $container->registerImplementation(
            CanvasInterface::class,
            GifbuilderCanvas::class
        );
        $container->registerImplementation(
            ResourceFactoryInterface::class,
            FilesContentObjectResourceFactory::class
        );
        // @NOTE: necessary for the FrontendAuthentication service (ReCaptcha)
        $container->registerImplementation(
            ClientInterface::class,
            Client::class
        );
        $container->registerImplementation(
            FactoryInterface::class,
            Typo3PagesFactory::class
        );
    }

    private static function registerEventListeners()
    {
        $dispatcher = self::getEventDispatcher();

        // -- register contact form mailing handler
        $dispatcher->connect(
            ContactController::class,
            'send',
            Carrier::class,
            'convey'
        );

        // -- register secret santa donor/donee pair persister
        $dispatcher->connect(
            Resolver::class,
            'FoundDonee',
            PersistSecretSantaPairListener::class,
            'handle'
        );

        // -- register code snippet brush registration
        $dispatcher->connect(
            SyntaxHighlighterParser::class,
            'RegisterCodeSnippetBrush',
            RegisterSyntaxHighlighterBrushListener::class,
            'handle'
        );

        // -- register dispatcher slot for deferred loading of code snippet page assets
        $dispatcher->connect(
            RequestDispatcher::class,
            'afterRequestDispatch',
            JsFooterInlineCodeListener::class,
            'handle'
        );
    }

    /**
     * @return Container
     */
    private static function getContainer()
    {
        return GeneralUtility::makeInstance(Container::class);
    }

    /**
     * @return Dispatcher
     */
    private static function getEventDispatcher()
    {
        return GeneralUtility::makeInstance(Dispatcher::class);
    }
}
