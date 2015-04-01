<?php
$TYPO3_CONF_VARS['EXTCONF']['realurl'] = array(
	'_DEFAULT' => array(
		'init' => array(
			'enableCHashCache' => TRUE,
			'appendMissingSlash' => 'ifNotFile',
			'enableUrlDecodeCache' => TRUE,
			'enableUrlEncodeCache' => TRUE,
			'emptyUrlReturnValue' => '/',
			'reapplyAbsRefPrefix' => TRUE,
		),
		'preVars' => array(
			/*
			array(
				'GETvar' => 'L',
				'valueMap' => array(
					'de' => '0',
					'en' => '1'
				),
				'valueDefault' => 'de',
			),
			*/
		),
		'pagePath' => array(
			'type' => 'user',
			'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
			'spaceCharacter' => '-',
			'languageGetVar' => 'L',
			'expireDays' => 30,
			'rootpage_id' => 136,
		),
		'fixedPostVars' => array(
		),
		'postVarSets' => array(
			'_DEFAULT' => array(
				// dont use no_cache in preVars
				// @see http://typo3bloke.net/post-details/archive/2006/september/12/do_not_use_no_cache_as_prevar/index.htm
				/*
				'nc' => array(
					'type' => 'single',
					'GETvar' => 'no_cache',
				),
				*/

				// archive - START
				'archive-date' => array(
					array('GETvar' => 'tx_vantomas_archivesearch[month]'),
					array('GETvar' => 'tx_vantomas_archivesearch[year]'),
					array(
						'GETvar' => 'tx_vantomas_archivesearch[controller]',
						'noMatch' => 'bypass'
					),
					array(
						'GETvar' => 'tx_vantomas_archivesearch[action]',
						'noMatch' => 'bypass'
					),
				),
				// archive - END

				'tag' => array(
					array(
						'GETvar' => 'tx_vantomas_tagsearch[controller]',
						'noMatch' => 'bypass'
					),
					array(
						'GETvar' => 'tx_vantomas_tagsearch[action]',
						'valueMap' => array(),
						'noMatch' => 'bypass'
					),
					array(
						'GETvar' => 'tx_vantomas_tagsearch[tag]'
					),
				),

				// tx_vantomas_contactform[action]=success&tx_vantomas_contactform[controller]=Form&cHash=...
				'contact' => array(
					array(
						'GETvar' => 'tx_vantomas_contactform[controller]',
						'valueMap' => array(),
						'noMatch' => 'bypass',
					),
					array(
						'GETvar' => 'tx_vantomas_contactform[action]',
						'valueMap' => array(
							'send' => 'sendContact',
							'success' => 'success',
						),
						'noMatch' => 'bypass',
					),
				),
			)
		),
		'fileName' => array (
			'index' => array(
				'rss.xml' => array(
					'keyValues' => array(
						'type' => 100
					)
				),
				'rss091.xml' => array(
					'keyValues' => array(
						'type' => 101
					)
				),
				'rdf.xml' => array(
					'keyValues' => array(
						'type' => 102
					)
				),
				'atom.xml' => array(
					'keyValues' => array(
						'type' => 103
					)
				),
				'sitemap.xml' => array(
					'keyValues' => array(
						'type' => 666
					)
				),
				'page.html' => array(
					'keyValues' => array(
						'type' => 1
					)
				),
				'print.html' => array(
					'keyValues' => array(
						'print' => 1
					)
				),
				'index.html' => array(
					'keyValues' => array(),
				)
			),
			'defaultToHTMLsuffixOnPrev' => 1,
		),
	)
);