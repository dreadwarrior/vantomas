<?php
$GLOBALS['TCA']['pages_language_overlay']['ctrl']['typeicon_classes']['30'] = 'vantomas-blog-article';

$GLOBALS['TCA']['pages_language_overlay']['columns']['doktype']['config']['items'][] = [
    'LLL:EXT:vantomas/Resources/Private/Language/locallang.xlf:pages.doktype.blog_article',
    30,
    'vantomas-blog-article',
];
