<?php
defined('TYPO3_MODE') or die();

// -- Core stuff

// 1. Interface implementations and SignalSlot event listeners
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \DreadLabs\Vantomas\DependencyInjection\DreadLabsVantomasExtension::class,
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Extbase\Object\Container\Container::class
    ),
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
    )
)->load();

// 2. Caching framework
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \DreadLabs\Vantomas\Configuration\CachingFramework::class
)->configure();

// 3. TypoScript enhancements
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \DreadLabs\Vantomas\TypoScript\ValueModifier::class
)->register();

// -- Backend stuff

// 1. Page TSConfig
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:vantomas/Configuration/TSConfig/page.ts">'
);

// 2. User TSConfig
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
    'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . \DreadLabs\Vantomas\Page\PageType::BLOG_ARTICLE . ')'
);

// 3. Backend layouts
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \DreadLabs\Vantomas\Backend\LayoutDataProvider::class
)->register();

// -- Frontend stuff

// 1. Auth services
\DreadLabs\Vantomas\Authentication\Frontend\ReCaptcha::register();

// 2. PageRenderer
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \DreadLabs\Vantomas\Hook\PageRenderer\FrontendHookRegistry::class
)->addPostProcessor(
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\Homepage\SiteNameMicrodata::class
    )
)->addPostProcessor(
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\Homepage\AtomFeedLink::class,
        103,
        'TYPO3, Ubuntu, Open Source'
    )
)->addPostProcessor(
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\Article\JsonLdLink::class,
        1453488849009
    )
)->addPostProcessor(
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\MobileExperience\Icons::class
    )
)->addPostProcessor(
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\MobileExperience\Colors::class
    )
)->addPostProcessor(
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \DreadLabs\Vantomas\Page\PageRenderer\PostProcessor\MobileExperience\WebManifest::class,
        1457380125731
    )
)->register();

// 3. Controller
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \DreadLabs\Vantomas\Hook\TypoScriptFrontendController\ContentPostProcessorHookRegistry::class
)->processOnBeforeOutput(
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \DreadLabs\Vantomas\Frontend\Controller\ContentPostProcessor\CdnReplacement::class
    )
)->register();

// -- Plugins

// 1. Archive

// 1.1 List
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'ArchiveList',
    [
        'Archive\\List' => 'show'
    ],
    []
);

// 1.2 Search
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'ArchiveSearch',
    [
        'Archive\\Search' => 'show'
    ],
    []
);

// 2. Last updated pages
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'SiteLastUpdatedPages',
    [
        'Site\\LastUpdatedPages' => 'list'
    ],
    []
);
\DreadLabs\Vantomas\Hook\PageLayoutView\DrawItem\SiteLastUpdatedPages::register($_EXTKEY);

// 3. Latest disqus comments
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'DisqusLatest',
    [
        'SocialNetworking\\Disqus' => 'latest'
    ],
    []
);

// 4. Twitter

// 4.1 Timeline tweets
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'TwitterTimeline',
    [
        'SocialNetworking\\Twitter' => 'timeline'
    ],
    []
);

// 4.2 Search results tweets
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'TwitterSearch',
    [
        'SocialNetworking\\Twitter' => 'search'
    ],
    []
);

// 5. Taxonomy

// 5.1 Tag cloud
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'TagCloud',
    [
        'Taxonomy\\TagCloud' => 'show'
    ],
    []
);

// 5.2 Tag search
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'TagSearch',
    [
        'Taxonomy\\TagSearch' => 'list'
    ],
    []
);

// 6. Contact form
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

// 7. RSS feed
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'RssFeed',
    [
        'Semantics\\RssFeed' => 'generate'
    ],
    []
);

// 8. sitemap.xml
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'SitemapXml',
    [
        'Semantics\\SitemapXml' => 'generate'
    ],
    []
);

// 9. Blog article .jsonld representation
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'LinkedData',
    [
        'Semantics\\LinkedData' => 'generate',
    ],
    []
);

// 10. webmanifest.json
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'WebManifest',
    [
        'Semantics\\WebManifest' => 'generate',
    ],
    []
);

// 11. secret santa

// 11.1 Login, logout
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

// 11.2 Show donee (Donor-donee-pairing)
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

// 12. Deferred page assets renderer
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'PageAssetsSyntaxHighlighter',
    [
        'PageAssets\\SyntaxHighlighter' => 'jsFooterInline'
    ],
    []
);

// 13. Content elements

// 13.1 Orbiter
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DreadLabs.' . $_EXTKEY,
    'Orbiter',
    [
        'Content\\Orbiter' => 'show'
    ],
    [],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// 13.2 Code snippet
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
