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
	'van-tomas.de - Archive list functionality'
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
	'van-tomas.de - Archive search functionality'
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
	'van-tomas.de - Last updated pages'
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
	'van-tomas.de - Latest disqus comments'
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
	'van-tomas.de - Twitter timeline'
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
	'van-tomas.de - Twitter search'
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
	'van-tomas.de - Tag cloud'
);

// -- 2. tag search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagSearch',
	'van-tomas.de - Tag search'
);

// -- contact form

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'ContactForm',
	'van-tomas.de - Contact form'
);


\DreadLabs\Vantomas\Utility\ExtensionManagement::addPluginFlexform(
	$_EXTKEY,
	'ContactForm',
	'Form/Contact.xml'
);

// -- secret santa

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_secretsanta'] = 'layout,select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DreadLabs.' . $_EXTKEY,
	'SecretSanta',
	'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:plugin.secretsanta.title',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('vantomas') . 'Resources/Public/Icons/SecretSanta.png'
);

if (TYPO3_MODE == 'BE') {
	\DreadLabs\Vantomas\Hook\NewContentElementWizardIcon\SecretSanta::register($_EXTKEY);
	\DreadLabs\Vantomas\Hook\PageLayoutView\DrawItem\PageStatisticsLastUpdated::register($_EXTKEY);
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
