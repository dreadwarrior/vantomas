<?php
defined('TYPO3_MODE') or die();

// -- Core stuff

// 1. Register icons
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \DreadLabs\Vantomas\Backend\IconRegistry::class,
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    )
)->register();

// -- Static TypoScript

// 1. Site
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Page/Site',
    'van-tomas.de Website package'
);


// 2. Sitemap
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Page/SitemapXml',
    'van-tomas.de sitemap.xml generator'
);

// 3. RSS feed
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Page/RssFeed',
    'van-tomas.de RSS feed generator'
);

// 4. Linked data
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Page/LinkedData',
    'van-tomas.de Linked Data for blog articles'
);

// 5. webmanifest.json
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Page/WebManifest',
    'van-tomas.de webmanifest.json'
);

// 6. Additional static TypoScript

// 6.1 Rendering helper
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Auxiliary/Rendering',
    'Rendering helper'
);

// 6.2 Custom RTE tag
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Auxiliary/LabsCustomTag',
    'Labs: custom RTE tag'
);

// 6.3. Secret santa
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Auxiliary/SecretSanta',
    'Secret Santa'
);

// -- Plugins

// 1. Archive

// 1.1 List
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'ArchiveList',
    'van-tomas.de - Archive list functionality',
    'EXT:vantomas/Resources/Public/Icons/ArchiveList.png'
);

// 1.2 Search
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'ArchiveSearch',
    'van-tomas.de - Archive search functionality',
    'EXT:vantomas/Resources/Public/Icons/ArchiveSearch.png'
);

// 2. Last updated pages
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'SiteLastUpdatedPages',
    'van-tomas.de - Last updated pages',
    'EXT:vantomas/Resources/Public/Icons/LastUpdatedPages.png'
);

// 3. Latest disqus comments
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'DisqusLatest',
    'van-tomas.de - Latest disqus comments',
    'EXT:vantomas/Resources/Public/Icons/LatestDisqusComments.png'
);

// 4. Twitter

// 4.1 Timeline tweets
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'TwitterTimeline',
    'van-tomas.de - Twitter timeline',
    'EXT:vantomas/Resources/Public/Icons/TwitterTimeline.png'
);

// 4.2. Search tweets
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'TwitterSearch',
    'van-tomas.de - Twitter search',
    'EXT:vantomas/Resources/Public/Icons/TwitterSearch.png'
);

// 5. Taxonomy

// 5.1 Tag cloud
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'TagCloud',
    'van-tomas.de - Tag cloud',
    'EXT:vantomas/Resources/Public/Icons/TagCloud.png'
);

// 5.2 Tag search
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'TagSearch',
    'van-tomas.de - Tag search',
    'EXT:vantomas/Resources/Public/Icons/TagCloud.png'
);

// 6. Contact form
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'ContactForm',
    'van-tomas.de - Contact form',
    'EXT:vantomas/Resources/Public/Icons/Contact.png'
);

// 7. Secret santa

// 7.1 Login, logout
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'SecretSantaAccessControl',
    'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:plugin.secretsanta_accesscontrol.title',
    'EXT:vantomas/Resources/Public/Icons/SecretSanta.png'
);

// 7.2. Show donee (Donor-donee-pairint)
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'SecretSantaRevealDonee',
    'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:plugin.secretsanta_revealdonee.title',
    'EXT:vantomas/Resources/Public/Icons/SecretSanta.png'
);
