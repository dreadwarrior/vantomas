<?php
// -- Plugin flexforms

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \DreadLabs\Vantomas\Utility\ExtensionManagement::class
)->addPluginFlexform(
    'vantomas',
    'ArchiveList',
    'Archive/List.xml'
)->addPluginFlexform(
    'vantomas',
    'ArchiveSearch',
    'Archive/Search.xml'
)->addPluginFlexform(
    'vantomas',
    'SiteLastUpdatedPages',
    'Site/LastUpdatedPages.xml'
)->addPluginFlexform(
    'vantomas',
    'DisqusLatest',
    'Disqus/Latest.xml'
)->addPluginFlexform(
    'vantomas',
    'TwitterTimeline',
    'Twitter/Timeline.xml'
)->addPluginFlexform(
    'vantomas',
    'TwitterSearch',
    'Twitter/Search.xml'
)->addPluginFlexform(
    'vantomas',
    'ContactForm',
    'Form/Contact.xml'
);

// -- Secret santa
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['vantomas_secretsanta'] = 'layout,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelsit']['vantomas_secretsantaaccesscontrol'] = 'layout,select_key';

// -- Custom content elements

$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_contentelements.header',
    '--div--',
];

// 1. Orbiter
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:content_element.orbiter',
    'vantomas_orbiter',
    'EXT:vantomas/Resources/Public/Icons/Orbiter.png'
];
$GLOBALS['TCA']['tt_content']['types']['vantomas_orbiter']['showitem'] = '
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

// 2. Code snippet
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:content_element.code_snippet',
    'vantomas_codesnippet',
    'EXT:vantomas/Resources/Public/Icons/CodeSnippet.svg'
];
$GLOBALS['TCA']['tt_content']['types']['vantomas_codesnippet']['showitem'] = '
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:palette.general;general,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
        bodytext;LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:tt_content.bodytext.ALT.code_snippet,
    --div--;LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:tt_content.tabs.code_snippet.configuration,rowDescription;LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:tt_content.rowDescription.ALT.configuration,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.image_settings;image_settings,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.imageblock;imageblock,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';
$GLOBALS['TCA']['tt_content']['types']['vantomas_codesnippet']['columnsOverrides']['bodytext'] = [
    'config' => [
        'format' => 'mixed',
        'renderType' => 't3editor',
    ],
    'defaultExtras' => 'nowrap:wizards[t3editor]',
];
