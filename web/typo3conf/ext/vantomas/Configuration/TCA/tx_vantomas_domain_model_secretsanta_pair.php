<?php
return [
    'ctrl' =>  [
        'title' => 'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:tx_vantomas_domain_model_secretsanta_pair',
        'label' => 'uid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate',
        'delete' => 'deleted',
        'enablecolumns' =>  [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:vantomas/Resources/Public/Icons/tx_vantomas_domain_model_secretsanta_pair.png',
    ],
    'interface' =>  [
        'showRecordFieldList' => 'hidden,donor,donee'
    ],
    'columns' =>  [
        'hidden' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' =>  [
                'type' => 'check',
                'default' => '0'
            ]
        ],
        'donor' =>  [
            'exclude' => 0,
            'label' => 'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:tx_vantomas_domain_model_secretsanta_pair.donor',
            'config' =>  [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ]
        ],
        'donee' =>  [
            'exclude' => 0,
            'label' => 'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:tx_vantomas_domain_model_secretsanta_pair.donee',
            'config' =>  [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ]
        ],
    ],
    'types' =>  [
        '0' => ['showitem' => 'hidden, --palette--;;1, donor, donee']
    ],
    'palettes' =>  [
        '1' => ['showitem' => '']
    ]
];
