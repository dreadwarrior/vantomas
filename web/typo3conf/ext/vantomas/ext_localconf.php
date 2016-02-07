<?php
defined('TYPO3_MODE') or die();

/* @var $extbaseContainer \TYPO3\CMS\Extbase\Object\Container\Container */
$extbaseContainer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Extbase\Object\Container\Container::class
);

// -- early registration of implementations
// @NOTE: this is necessary in FLUIDTEMPLATE based PAGE rendering contexts
// @see: https://forge.typo3.org/issues/50788
$extbaseContainer->registerImplementation(
    \DreadLabs\VantomasWebsite\TeaserImage\CanvasFactoryInterface::class,
    \DreadLabs\Vantomas\Domain\TeaserImage\FoldedPaperWithGrungeCanvasFactory::class
);
$extbaseContainer->registerImplementation(
    \DreadLabs\VantomasWebsite\TeaserImage\CanvasInterface::class,
    \DreadLabs\Vantomas\Domain\TeaserImage\GifbuilderCanvas::class
);
$extbaseContainer->registerImplementation(
    \DreadLabs\VantomasWebsite\TeaserImage\ResourceFactoryInterface::class,
    \DreadLabs\Vantomas\Domain\TeaserImage\FilesContentObjectResourceFactory::class
);
// @NOTE: necessary for the FrontendAuthentication service (ReCaptcha)
$extbaseContainer->registerImplementation(
    \DreadLabs\VantomasWebsite\Http\ClientInterface::class,
    \DreadLabs\VantomasWebsite\Http\NetHttpAdapter\Client::class
);
$extbaseContainer->registerImplementation(
    \DreadLabs\VantomasWebsite\Page\FactoryInterface::class,
    \DreadLabs\Vantomas\Domain\Page\Typo3PagesFactory::class
);

if (TYPO3_MODE == 'BE') {
    // -- register backend layout provider
    // @NOTE: last key in hook here is prefix for the layout identifier...
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['BackendLayoutDataProvider'][$_EXTKEY] = \DreadLabs\Vantomas\Backend\LayoutDataProvider::class;

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:vantomas/Configuration/TSConfig/page.ts">'
    );
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('
config {
    removeDefaultJS = ' . getenv('TS_CONFIG_REMOVEDEFAULTJS') . '
    no_cache = ' . getenv('TS_CONFIG_NOCACHE') . '
    disablePrefixComment = ' . getenv('TS_CONFIG_DISABLEPREFIXCOMMENT') . '
    tx_realurl_enable = ' . getenv('TS_CONFIG_TXREALURLENABLE') . '
    sendCacheHeaders = ' . getenv('TS_CONFIG_SENDCACHEHEADERS') . '

    cdn {
        replace {
            http {
                20 = "http://' . getenv('TS_CONFIG_CDN_REPLACE_FILEADMIN') . '
                21 = "http://' . getenv('TS_CONFIG_CDN_REPLACE_FILEADMIN') . '
                30 = "http://' . getenv('TS_CONFIG_CDN_REPLACE_TYPO3CONF') . '
                31 = "http://' . getenv('TS_CONFIG_CDN_REPLACE_TYPO3CONF') . '
                40 = "http://' . getenv('TS_CONFIG_CDN_REPLACE_TYPO3TEMP') . '
                41 = "http://' . getenv('TS_CONFIG_CDN_REPLACE_TYPO3TEMP') . '
            }
            https {
                20 = "https://' . getenv('TS_CONFIG_CDN_REPLACE_FILEADMIN') . '
                21 = "https://' . getenv('TS_CONFIG_CDN_REPLACE_FILEADMIN') . '
                30 = "https://' . getenv('TS_CONFIG_CDN_REPLACE_TYPO3CONF') . '
                31 = "https://' . getenv('TS_CONFIG_CDN_REPLACE_TYPO3CONF') . '
                40 = "https://' . getenv('TS_CONFIG_CDN_REPLACE_TYPO3TEMP') . '
                41 = "https://' . getenv('TS_CONFIG_CDN_REPLACE_TYPO3TEMP') . '
            }
        }
    }
}
plugin.tx_vantomas.settings {
    twitter {
        consumerKey = ' . getenv('TWITTER_CONSUMERKEY') . '
        consumerSecret = ' . getenv('TWITTER_CONSUMERSECRET') . '
    }

    disqus {
        apiKey = ' . getenv('DISQUS_APIKEY') . '
    }
    mail.DreadLabs\VantomasWebsite\Form\Contact {
        sender {
            1 {
                mail = ' . getenv('TS_PLUGIN_TXVANTOMAS_SETTINGS_MAIL_CONTACT_SENDER_MAIL') . '
                name = ' . getenv('TS_PLUGIN_TXVANTOMAS_SETTINGS_MAIL_CONTACT_SENDER_NAME') . '
            }
        }
        receiver {
            1 {
                mail = ' . getenv('TS_PLUGIN_TXVANTOMAS_SETTINGS_MAIL_CONTACT_RECEIVER_MAIL') . '
                name = ' . getenv('TS_PLUGIN_TXVANTOMAS_SETTINGS_MAIL_CONTACT_RECEIVER_NAME') . '
            }
        }
    }
}
rss_feed.typeNum = ' . getenv('TS_RSSFEED_TYPENUM') . '
');

// -- feature: RTE 4 abstract

$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['vantomas']);

\DreadLabs\Vantomas\Utility\ExtensionManagement\PageAbstractRte::configure($extConf);

// -- archive plugins

// -- 1. archive list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'ArchiveList',
    [
        'Archive\\List' => 'show'
    ],
    []
);

// -- 2. archive search
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'ArchiveSearch',
    [
        'Archive\\Search' => 'show'
    ],
    []
);

// -- last updated pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'SiteLastUpdatedPages',
    [
        'Site\\LastUpdatedPages' => 'list'
    ],
    []
);

\DreadLabs\Vantomas\Hook\PageLayoutView\DrawItem\SiteLastUpdatedPages::register($_EXTKEY);

// -- comment plugins

// -- 1. latest disqus comments
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'DisqusLatest',
    [
        'SocialNetworking\\Disqus' => 'latest'
    ],
    []
);

// -- twitter plugins

// -- 1. timeline tweets
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'TwitterTimeline',
    [
        'SocialNetworking\\Twitter' => 'timeline'
    ],
    []
);

// -- 2. search tweets
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'TwitterSearch',
    [
        'SocialNetworking\\Twitter' => 'search'
    ],
    []
);

// -- tag cloud/search plugins

// -- 1. tag cloud
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'TagCloud',
    [
        'Taxonomy\\TagCloud' => 'show'
    ],
    []
);

// -- 2. tag search
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'TagSearch',
    [
        'Taxonomy\\TagSearch' => 'list'
    ],
    []
);

// -- contact form

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'ContactForm',
    [
        'Form\\Contact' => 'new, send, success',
    ],
    [
        'Form\\Contact' => 'new, send, success',
    ]
);

// -- RSS feed

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'RssFeed',
    [
        'Semantics\\RssFeed' => 'generate'
    ],
    []
);

// -- sitemap.xml

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'SitemapXml',
    [
        'Semantics\\SitemapXml' => 'generate'
    ],
    []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'LinkedData',
    [
        'Semantics\\LinkedData' => 'generate',
    ],
    []
);

// -- secret santa

\TYPO3\CMS\Extbase\Utility\Extensionutility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'SecretSantaAccessControl',
    [
        'SecretSanta\\AccessControl' => 'form,login,logout',
    ],
    [
        'SecretSanta\\AccessControl' => 'form,login,logout',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'SecretSantaRevealDonee',
    [
        'SecretSanta\\RevealDonee' => 'show',
    ],
    [
        'SecretSanta\\RevealDonee' => 'show',
    ]
);

// -- deferred page assets renderer

// -- 1. code snippet (SyntaxHighlighter)
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'PageAssetsSyntaxHighlighter',
    [
        'PageAssets\\SyntaxHighlighter' => 'jsFooterInline'
    ],
    []
);

// -- content elements

// -- 1. orbiter
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'Orbiter',
    [
        'Content\\Orbiter' => 'show'
    ],
    [],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// -- 2. code snippet
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'CodeSnippet',
    [
        'Content\\CodeSnippet' => 'show',
    ],
    [],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
\DreadLabs\Vantomas\Hook\PageLayoutView\DrawItem\CodeSnippet::register($_EXTKEY);

/* @var $signalSlotDispatcher \TYPO3\CMS\Extbase\SignalSlot\Dispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
);

// -- register contact form mailing handler
$signalSlotDispatcher->connect(
    \DreadLabs\Vantomas\Controller\Form\ContactController::class,
    'send',
    \DreadLabs\VantomasWebsite\Mail\Carrier::class,
    'convey'
);

// -- register secret santa donor/donee pair persister
$signalSlotDispatcher->connect(
    \DreadLabs\VantomasWebsite\SecretSanta\Donee\Resolver::class,
    'FoundDonee',
    \DreadLabs\Vantomas\Domain\EventListener\PersistSecretSantaPairListener::class,
    'handle'
);

// -- register code snippet brush registration
$signalSlotDispatcher->connect(
    \DreadLabs\VantomasWebsite\CodeSnippet\SyntaxHighlighterParser::class,
    'RegisterCodeSnippetBrush',
    \DreadLabs\Vantomas\Domain\EventListener\RegisterSyntaxHighlighterBrushListener::class,
    'handle'
);

// -- register dispatcher slot for deferred loading of code snippet page assets
$signalSlotDispatcher->connect(
    \TYPO3\CMS\Extbase\Mvc\Dispatcher::class,
    'afterRequestDispatch',
    \DreadLabs\Vantomas\Domain\EventListener\JsFooterInlineCodeListener::class,
    'handle'
);

// -- caches

// -- 1. code snippet brushes
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['codesnippet_brushes'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['codesnippet_brushes'] = [];
}
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['codesnippet_brushes']['backend'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['codesnippet_brushes']['backend'] = \TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class;
}

// -- register page meta data hooks
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \DreadLabs\Vantomas\Hook\PageRenderer\PostProcessor\SiteNameMicrodata::class . '->render';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \DreadLabs\Vantomas\Hook\PageRenderer\PostProcessor\AtomFeedLink::class . '->render';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \DreadLabs\Vantomas\Hook\PageRenderer\PostProcessor\BlogArticleJsonLdLink::class . '->render';

$cdnInterceptor = \DreadLabs\Vantomas\Hook\TypoScriptFrontendControllerHook::class . '->interceptCdnReplacements';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = $cdnInterceptor;

// -- register threat detection auth service for frontend
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    $_EXTKEY,
    'auth',
    \DreadLabs\Vantomas\Authentication\Frontend\ReCaptcha::class,
    [
        'title' => 'Frontend login threat detection',
        'description' => 'Detects threats on the frontend login',
        'subtype' => 'authUserFE',
        'available' => true,
        // must be higher than \TYPO3\CMS\Sv\AuthenticationService (50), rsaauth (60) and saltedpasswords (70)
        'priority' => 90,
        'quality' => 50,
        'os' => '',
        'exec' => '',
        'className' => \DreadLabs\Vantomas\Authentication\Frontend\ReCaptcha::class,
    ]
);
