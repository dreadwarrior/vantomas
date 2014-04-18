<?php
/**
 * RealURL configuration for van-tomas.de
 *
 */
$TYPO3_CONF_VARS['EXTCONF']['realurl'] = array(
	// sitename
	'_DEFAULT' => array(
		// initialization
		'init' => array(
			'useCHashCache' => '0', // für tt_news
			'enableCHashCache' => true,
			'appendMissingSlash' => 'ifNotFile',
			'enableUrlDecodeCache' => true,
			'enableUrlEncodeCache' => true,
			'emptyUrlReturnValue' => '/'
		),
		// first url rewriting segment
		'preVars' => array(
			/*
			array(
				'GETvar' => 'L',
				'valueMap' => array(
					'de' => '0',
					'en' => '1' // ###SYS_LANGUAGE_EN###
				),
				'valueDefault' => 'de',
			),
			*/
		),
		// second url rewriting segment
		'pagePath' => array(
			'type' => 'user',
			'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
			'spaceCharacter' => '-',
			'languageGetVar' => 'L',
			'expireDays' => 30,
			'rootpage_id' => 136, // ###ROOTPAGE_UID###
		),
		// third url rewriting segment
		'fixedPostVars' => array(
		),
		// forth url rewriting segment
		'postVarSets' => array(
			'_DEFAULT' => array(
				/*
					no_cache Einstellung - sollte laut
					http://typo3bloke.net/post-details/archive/2006/september/12/do_not_use_no_cache_as_prevar/index.htm
					nicht in preVars verwendet werden
				*/
				'nc' => array(
					'type' => 'single',
					'GETvar' => 'no_cache',
				),
				// archive - START
				/*
				'archive-date' => array(
					array('GETvar' => 'archive[year]'),
					array('GETvar' => 'archive[month]')
				),
				*/
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
					array('GETvar' => 'tx_vgetagcloud_pi2[pages]'),
					array('GETvar' => 'tx_vgetagcloud_pi2[keyword]')
				)
			)
		),
		// fifth url rewriting segment
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

$TYPO3_CONF_VARS['EXTCONF']['realurl']['mobile.van-tomas.de'] = $TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['mobile.van-tomas.de']['pagePath']['rootpage_id'] = 217;
?>