<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Page/Site',
    'van-tomas.de Website package'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Page/SitemapXml',
    'van-tomas.de sitemap.xml generator'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Page/RssFeed',
    'van-tomas.de RSS feed generator'
);

// -- additional static TS

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Auxiliary/Rendering',
    'Rendering helper'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Auxiliary/LabsCustomTag',
    'Labs: custom RTE tag'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/Auxiliary/SecretSanta',
    'Secret Santa'
);

// -- archive plugins

// -- 1. archive list

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'ArchiveList',
    'van-tomas.de - Archive list functionality',
    'EXT:vantomas/Resources/Public/Icons/ArchiveList.png'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
    $_EXTKEY,
    'ArchiveList',
    'Archive/List.xml'
);

// -- 2. archive search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'ArchiveSearch',
    'van-tomas.de - Archive search functionality',
    'EXT:vantomas/Resources/Public/Icons/ArchiveSearch.png'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
    $_EXTKEY,
    'ArchiveSearch',
    'Archive/Search.xml'
);

// last updated pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'SiteLastUpdatedPages',
    'van-tomas.de - Last updated pages',
    'EXT:vantomas/Resources/Public/Icons/LastUpdatedPages.png'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
    $_EXTKEY,
    'SiteLastUpdatedPages',
    'Site/LastUpdatedPages.xml'
);

// -- comment plugins

// -- 1. latest disqus comments

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'DisqusLatest',
    'van-tomas.de - Latest disqus comments',
    'EXT:vantomas/Resources/Public/Icons/LatestDisqusComments.png'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
    $_EXTKEY,
    'DisqusLatest',
    'Disqus/Latest.xml'
);

// -- twitter plugins

// -- 1. timeline tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'TwitterTimeline',
    'van-tomas.de - Twitter timeline',
    'EXT:vantomas/Resources/Public/Icons/TwitterTimeline.png'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
    $_EXTKEY,
    'TwitterTimeline',
    'Twitter/Timeline.xml'
);

// -- 2. search tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'TwitterSearch',
    'van-tomas.de - Twitter search',
    'EXT:vantomas/Resources/Public/Icons/TwitterSearch.png'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
    $_EXTKEY,
    'TwitterSearch',
    'Twitter/Search.xml'
);

// -- tag cloud/search plugins

// -- 1. tag cloud

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'TagCloud',
    'van-tomas.de - Tag cloud',
    'EXT:vantomas/Resources/Public/Icons/TagCloud.png'
);

// -- 2. tag search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'TagSearch',
    'van-tomas.de - Tag search',
    'EXT:vantomas/Resources/Public/Icons/TagCloud.png'
);

// -- contact form

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'ContactForm',
    'van-tomas.de - Contact form',
    'EXT:vantomas/Resources/Public/Icons/Contact.png'
);


\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
    $_EXTKEY,
    'ContactForm',
    'Form/Contact.xml'
);

// -- secret santa

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_secretsanta'] = 'layout,select_key';
$TCA['tt_content']['types']['list']['subtypes_excludelsit'][$_EXTKEY . '_secretsantaaccesscontrol'] = 'layout,select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'SecretSantaRevealDonee',
    'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:plugin.secretsanta_revealdonee.title',
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('vantomas') . 'Resources/Public/Icons/SecretSanta.png'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DreadLabs.' . $_EXTKEY,
    'SecretSantaAccessControl',
    'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:plugin.secretsanta_accesscontrol.title',
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('vantomas') . 'Resources/Public/Icons/SecretSanta.png'
);

// -- custom content elements

$TCA['tt_content']['columns']['CType']['config']['items'][] = array(
    'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_contentelements.header',
    '--div--',
);

// -- 1. orbiter
$TCA['tt_content']['columns']['CType']['config']['items'][] = array(
    'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:content_element.orbiter',
    'vantomas_orbiter',
    'EXT:vantomas/Resources/Public/Icons/Orbiter.png'
);
$TCA['tt_content']['types']['vantomas_orbiter']['showitem'] = '
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:palette.general;general,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
        rowDescription,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.images,image,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.imagelinks;imagelinks,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.image_settings;image_settings,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.imageblock;imageblock,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';

// -- feature: RTE 4 abstract

$pagesAbstractRteTcaExtras = 'richtext:rte_transform[flag=rte_enabled|mode=ts_css]';
$GLOBALS['TCA']['pages']['columns']['abstract']['defaultExtras'] = $pagesAbstractRteTcaExtras;

// -- register new doktype ("Blog article")

\DreadLabs\Vantomas\Utility\ExtensionManagement\PageTypeRegistry::registerPageType(
    $_EXTKEY,
    30,
    'doktype-blog-article.png',
    'pages.doktype.blog_article'
);
