<?php
return array(
    'ctrl' => array (
        'title' => 'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:tx_vantomas_domain_model_secretsanta_pair',
        'label' => 'uid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate',
        'delete' => 'deleted',
        'enablecolumns' => array (
            'disabled' => 'hidden',
        ),
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('vantomas') . 'Resources/Public/Icons/tx_vantomas_domain_model_secretsanta_pair.png',
    ),
    'interface' => array (
        'showRecordFieldList' => 'hidden,donor,donee'
    ),
    'columns' => array (
        'hidden' => array (
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array (
                'type' => 'check',
                'default' => '0'
            )
        ),
        'donor' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:tx_vantomas_domain_model_secretsanta_pair.donor',
            'config' => array (
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            )
        ),
        'donee' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:tx_vantomas_domain_model_secretsanta_pair.donee',
            'config' => array (
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            )
        ),
    ),
    'types' => array (
        '0' => array('showitem' => 'hidden, --palette--;;1, donor, donee')
    ),
    'palettes' => array (
        '1' => array('showitem' => '')
    )
);
