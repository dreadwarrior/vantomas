<?php
return [
    'BE' => [
        'compressionLevel' => '0',
        'disable_exec_function' => '0',
        'flexformForceCDATA' => '1',
        'loginSecurityLevel' => 'rsa',
        'versionNumberInFilename' => '0',
    ],
    'DB' => [
        'extTablesDefinitionScript' => 'extTables.php',
    ],
    'EXT' => [
        'allowGlobalInstall' => '0',
        'extConf' => [
            'beautyofcode' => 'a:1:{s:15:"enable_t3editor";s:1:"1";}',
            'css_styled_content' => 'a:2:{s:15:"setPageTSconfig";s:1:"1";s:19:"removePositionTypes";s:1:"1";}',
            'em' => 'a:4:{s:14:"showOldModules";s:1:"0";s:14:"inlineToWindow";s:1:"1";s:19:"displayMyExtensions";s:1:"1";s:17:"selectedLanguages";s:2:"de";}',
            'filemetadata' => 'a:0:{}',
            'lowlevel' => 'a:0:{}',
            'mediace' => 'a:0:{}',
            'opendocs' => 'a:1:{s:12:"enableModule";s:1:"0";}',
            'rtehtmlarea' => 'a:8:{s:21:"noSpellCheckLanguages";s:23:"ja,km,ko,lo,th,zh,b5,gb";s:15:"AspellDirectory";s:15:"/usr/bin/aspell";s:20:"defaultConfiguration";s:105:"Typical (Most commonly used features are enabled. Select this option if you are unsure which one to use.)";s:12:"enableImages";s:1:"0";s:20:"enableInlineElements";s:1:"0";s:19:"allowStyleAttribute";s:1:"0";s:24:"enableAccessibilityIcons";s:1:"0";s:16:"forceCommandMode";s:1:"0";}',
            'saltedpasswords' => 'a:6:{s:20:"checkConfigurationFE";s:1:"0";s:20:"checkConfigurationBE";s:1:"0";s:3:"FE.";a:5:{s:7:"enabled";s:1:"1";s:21:"saltedPWHashingMethod";s:41:"TYPO3\\CMS\\Saltedpasswords\\Salt\\PhpassSalt";s:11:"forceSalted";s:1:"0";s:15:"onlyAuthService";s:1:"0";s:12:"updatePasswd";s:1:"1";}s:3:"BE.";a:4:{s:21:"saltedPWHashingMethod";s:41:"TYPO3\\CMS\\Saltedpasswords\\Salt\\PhpassSalt";s:11:"forceSalted";s:1:"0";s:15:"onlyAuthService";s:1:"0";s:12:"updatePasswd";s:1:"1";}s:21:"checkConfigurationFE2";s:1:"0";s:21:"checkConfigurationBE2";s:1:"0";}',
            'static_info_tables' => 'a:4:{s:13:"enableManager";s:1:"0";s:5:"dummy";s:1:"0";s:7:"charset";s:5:"utf-8";s:12:"usePatch1822";s:1:"0";}',
            'static_info_tables_de' => 'a:1:{s:5:"dummy";s:1:"0";}',
            'tstemplate_analyzer' => 'a:0:{}',
            'tstemplate_objbrowser' => 'a:0:{}',
            'vantomas' => 'a:1:{s:6:"pages.";a:1:{s:9:"abstract.";a:1:{s:4:"rte.";a:3:{s:15:"disableGlobally";s:1:"1";s:11:"showButtons";s:103:"bold, italic, left, center, right, orderedlist, unorderedlist, outdent, indent, insertcharacter, chMode";s:11:"hideButtons";s:606:"class, blockstylelabel, blockstyle, textstylelabel, textstyle, formatblock, subscript, superscript, textindicator, link, table, findreplace, removeformat, undo, redo, about, toggleborders, tableproperties, rowproperties, rowinsertabove, rowinsertunder, rowdelete, rowsplit, columninsertbefore, columninsertafter, columndelete, columnsplit, cellproperties, cellinsertbefore, cellinsertafter, celldelete, cellsplit, cellmerge, chMode, blockstyle, textstyle, underline, strikethrough, subscript, superscript, lefttoright, righttoleft, justifyfull, table, inserttag, findreplace, removeformat, copy, cut, paste";}}}}',
            'vhs' => 'a:0:{}',
        ],
    ],
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'de',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
        ],
    ],
    'FE' => [
        'compressionLevel' => '5',
        'disableNoCacheParameter' => '0',
        'lockIP' => '4',
        'loginSecurityLevel' => 'rsa',
        'noPHPscriptInclude' => '1',
        'pageNotFound_handling' => '/page-not-found/',
        'pageUnavailable_handling' => 'READFILE:EXT:vantomas/Resources/Private/Templates/Page/Maintenance.html',
        'permalogin' => '0',
        'versionNumberInFilename' => 'embed',
    ],
    'GFX' => [
        'colorspace' => 'RGB',
        'gdlib_png' => '1',
        'gif_compress' => '0',
        'im' => '1',
        'im_mask_temp_ext_gif' => '1',
        'im_noScaleUp' => '1',
        'im_path' => '/usr/bin/',
        'im_path_lzw' => '/usr/bin/',
        'im_v5effects' => '-1',
        'im_version_5' => 'gm',
        'image_processing' => '1',
        'imagefile_ext' => 'gif,jpg,jpeg,tif,bmp,pcx,tga,png,pdf,ai',
        'jpg_quality' => '85',
        'png_truecolor' => '1',
        'thumbnails_png' => '1',
    ],
    'HTTP' => [
        'adapter' => 'curl',
    ],
    'INSTALL' => [
        'wizardDone' => [
            'TYPO3\CMS\Install\CoreUpdates\CompressionLevelUpdate' => 1,
            'TYPO3\CMS\Install\CoreUpdates\InstallSysExtsUpdate' => '["info","perm","func","filelist","about","cshmanual","feedit","opendocs","recycler","t3editor","reports","scheduler","simulatestatic"]',
            'TYPO3\CMS\Install\Updates\BackendUserStartModuleUpdate' => 1,
            'TYPO3\CMS\Install\Updates\FileListIsStartModuleUpdate' => 1,
            'TYPO3\CMS\Install\Updates\MediaceExtractionUpdate' => 1,
            'TYPO3\CMS\Install\Updates\MigrateMediaToAssetsForTextMediaCe' => 1,
            'TYPO3\CMS\Rtehtmlarea\Hook\Install\DeprecatedRteProperties' => 1,
            'TYPO3\CMS\Rtehtmlarea\Hook\Install\RteAcronymButtonRenamedToAbbreviation' => 1,
            'tx_coreupdates_installnewsysexts' => '1',
            'tx_rtehtmlarea_deprecatedRteProperties' => '1',
        ],
    ],
    'SYS' => [
        'UTF8filesystem' => '0',
        'caching' => [
            'cacheConfigurations' => [
                'extbase_object' => [
                    'frontend' => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend',
                    'groups' => [
                        'system',
                    ],
                    'options' => [
                        'defaultLifetime' => 0,
                    ],
                ],
            ],
        ],
        'clearCacheSystem' => '1',
        'curlUse' => '1',
        'devIPmask' => '',
        'enable_DLOG' => '1',
        'enable_errorDLOG' => '0',
        'encryptionKey' => '02d0b8767673ce599e608f1daa046e3944d277487e9ff74033f2def62212d67c1eee95214646f61ac5867a7b76ddcc14',
        'errorHandler' => 'TYPO3\\CMS\\Core\\Error\\ErrorHandler',
        'exceptionalErrors' => '28917',
        'sqlDebug' => '0',
        't3lib_cs_convMethod' => 'mbstring',
        't3lib_cs_utils' => 'mbstring',
    ],
];
