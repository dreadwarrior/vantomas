<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript/Site',
	'van-tomas.de Website package'
);

// -- additional static TS

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript/LabsCustomTag',
	'Labs: custom RTE tag'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript/SecretSanta',
	'Secret Santa'
);

// -- archive plugins

// -- 1. archive list

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveList',
	'van-tomas.de - Archive list functionality',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/ArchiveList.png'
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
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/ArchiveSearch.png'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'ArchiveSearch',
	'Archive/Search.xml'
);

// -- page statistics plugins

// -- 1. last updated pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'PageStatisticsLastUpdated',
	'van-tomas.de - Last updated pages',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/LastUpdatedPages.png'
);

\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'PageStatisticsLastUpdated',
	'PageStatistics/LastUpdated.xml'
);

// -- comment plugins

// -- 1. latest disqus comments

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'DisqusLatest',
	'van-tomas.de - Latest disqus comments',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/LatestDisqusComments.png'
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
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TwitterTimeline.png'
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
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TwitterSearch.png'
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
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TagCloud.png'
);

// -- 2. tag search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagSearch',
	'van-tomas.de - Tag search',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TagCloud.png'
);

// -- contact form

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'ContactForm',
	'van-tomas.de - Contact form',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Contact.png'
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
	'SecretSanta',
	'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:plugin.secretsanta.title',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('vantomas') . 'Resources/Public/Icons/SecretSanta.png'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'SecretSantaAccessControl',
	'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:plugin.secretsanta_accesscontrol.title',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('vantomas') . 'Resources/Public/Icons/SecretSanta.png'
);

if (TYPO3_MODE == 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:vantomas/Configuration/TSConfig/page.ts">'
	);
}

// -- feature: RTE 4 abstract

$extConf = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['vantomas']);

\DreadLabs\Vantomas\Utility\ExtensionManagement\PageAbstractRte::configure($extConf);

$pagesAbstractRteTcaExtras = 'richtext:rte_transform[flag=rte_enabled|mode=ts_css]';
$GLOBALS['TCA']['pages']['columns']['abstract']['defaultExtras'] = $pagesAbstractRteTcaExtras;

// -- register new doktype ("Blog article")

\DreadLabs\Vantomas\Utility\ExtensionManagement\PageTypeRegistry::registerPageType(
	$_EXTKEY,
	30,
	'doktype-blog-article.png',
	'pages.doktype.blog_article'
);
