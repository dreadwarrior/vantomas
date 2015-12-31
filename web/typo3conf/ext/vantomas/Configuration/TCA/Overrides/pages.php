<?php
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['30'] = 'vantomas-blog-article';

$GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
    'LLL:EXT:vantomas/Resources/Private/Language/locallang.xlf:pages.doktype.blog_article',
    30,
    'vantomas-blog-article',
];

// -- feature: RTE 4 abstract

$pagesAbstractRteTcaExtras = 'richtext:rte_transform[flag=rte_enabled|mode=ts_css]';
$GLOBALS['TCA']['pages']['columns']['abstract']['defaultExtras'] = $pagesAbstractRteTcaExtras;
