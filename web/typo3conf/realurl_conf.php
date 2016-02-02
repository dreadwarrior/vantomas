<?php
$TYPO3_CONF_VARS['EXTCONF']['realurl'] = [
    '_DEFAULT' => [
        'init' => [
            'enableCHashCache' => true,
            // @see http://typo3.codeblocks.de/anleitungen-tipps/tutorials-codesnippets/realurl/trailing-slash-duplicate-content/
            'appendMissingSlash' => 'ifNotFile,redirect[301]',
            'enableUrlDecodeCache' => true,
            'enableUrlEncodeCache' => true,
            'emptyUrlReturnValue' => '/',
            'reapplyAbsRefPrefix' => true,
        ],
        'preVars' => [
        ],
        'pagePath' => [
            'type' => 'user',
            'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
            'spaceCharacter' => '-',
            'languageGetVar' => 'L',
            'expireDays' => 30,
            'rootpage_id' => 136,
        ],
        'fixedPostVars' => [
        ],
        'postVarSets' => [
            '_DEFAULT' => [
                // archive - START
                'archive-date' => [
                    ['GETvar' => 'tx_vantomas_archivesearch[month]'],
                    ['GETvar' => 'tx_vantomas_archivesearch[year]'],
                    [
                        'GETvar' => 'tx_vantomas_archivesearch[controller]',
                        'noMatch' => 'bypass'
                    ],
                    [
                        'GETvar' => 'tx_vantomas_archivesearch[action]',
                        'noMatch' => 'bypass'
                    ],
                ],
                // archive - END

                'tag' => [
                    [
                        'GETvar' => 'tx_vantomas_tagsearch[controller]',
                        'noMatch' => 'bypass'
                    ],
                    [
                        'GETvar' => 'tx_vantomas_tagsearch[action]',
                        'valueMap' => [],
                        'noMatch' => 'bypass'
                    ],
                    [
                        'GETvar' => 'tx_vantomas_tagsearch[tag]'
                    ],
                ],

                // tx_vantomas_contactform[action]=success&tx_vantomas_contactform[controller]=Form&cHash=...
                'contact-form' => [
                    [
                        'GETvar' => 'tx_vantomas_contactform[controller]',
                        'valueMap' => [],
                        'noMatch' => 'bypass',
                    ],
                    [
                        'GETvar' => 'tx_vantomas_contactform[action]',
                        'valueMap' => [
                            'send' => 'send',
                            'success' => 'success',
                        ],
                        'noMatch' => 'bypass',
                    ],
                ],

                // tx_vantomas_secretsanta[action]=loginForm&tx_vantomas_secretsanta[controller]=SecretSanta&cHash=...
                'wichtel-zugang' => [
                    [
                        'GETvar' => 'tx_vantomas_secretsantaaccesscontrol[controller]',
                        'valueMap' => [],
                        'noMatch' => 'bypass',
                    ],
                    [
                        'GETvar' => 'tx_vantomas_secretsantaaccesscontrol[action]',
                        'valueMap' => [
                            'anmelden' => 'login',
                            'abmelden' => 'logout',
                        ],
                        'noMatch' => 'bypass',
                    ],
                ],
                'wichtel' => [
                    [
                        'GETvar' => 'tx_vantomas_secretsanta[controller]',
                        'valueMap' => [],
                        'noMatch' => 'bypass',
                    ],
                    [
                        'GETvar' => 'tx_vantomas_secretsanta[action]',
                        'valueMap' => [
                            'anzeigen' => 'show',
                        ],
                        'noMatch' => 'bypass',
                    ],
                ],
            ]
        ],
        'fileName' =>  [
            'index' => [
                'atom.xml' => [
                    'keyValues' => [
                        'type' => 103,
                    ]
                ],
                'sitemap.xml' => [
                    'keyValues' => [
                        'type' => 666,
                    ]
                ],
                '.jsonld' => [
                    'keyValues' => [
                        'type' => 1453488849009,
                    ],
                ],
                '_DEFAULT' => [
                    'keyValues' => [
                    ],
                ],
            ],
            'defaultToHTMLsuffixOnPrev' => false,
            'acceptHTMLsuffix' => false,
        ],
    ],
];
