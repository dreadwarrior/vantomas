<?php
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][(string) \DreadLabs\Vantomas\Page\PageType::BLOG_ARTICLE] = 'vantomas-blog-article';

$GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
    'LLL:EXT:vantomas/Resources/Private/Language/locallang.xlf:pages.doktype.blog_article',
    \DreadLabs\Vantomas\Page\PageType::BLOG_ARTICLE,
    'vantomas-blog-article',
];
