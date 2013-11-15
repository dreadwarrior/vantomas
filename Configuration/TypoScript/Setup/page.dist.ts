page = PAGE
page {
	config {
		// bei Verwendung von indexed_search muss für Seiten, die indexiert werden sollen
		// diese Einstellung einkommentiert werden
		#index_enable = 1
	}

	typeNum = 0

	// ggf. deaktivieren bei Verwendung von unterschiedl. Templatetypen
	bodyTag = <body>
	meta {
		description = TEXT
		description.data = field:description
		keywords = TEXT
		keywords.data = field:keywords
		// Google Webmaster Tools Verification Code
		google-site-verification = {$site.google.webmastertools}
		viewport = width=device-width
	}

	headerData {
		// title-Attribut kommt aus Untertitel // Titel-Feld der Seite
		10 = TEXT
		10 {
			field = subtitle // title
			htmlSpecialChars = 1
			noTrimWrap = |<title>|</title>|
		}
	}

	
	includeJSlibs {
		modernizr = EXT:vantomas/Resources/Public/Javascript/vendor/custom.modernizr.js
	}

	includeCSS {
		google_fonts = //fonts.googleapis.com/css?family=Neuton|Lobster&amp;subset=latin,latin-ext
		google_fonts {
			disableCompression = 1
			excludeFromConcatenation = 1
			external = 1
			forceOnTop = 1
		}

		foundation_normalize = EXT:vantomas/Resources/Public/Css/normalize.css
		foundation_app = EXT:vantomas/Resources/Public/Css/app.css
	}

	1384540856 = TEXT
	1384540856 {
		value (
			<script>
				document.write('<script src=@@@CSS_IMAGES_ROOT_DIR@@@/Resources/Public/Javascript/vendor/' + ('__proto__' in {} ? 'zepto' : 'jquery') + '.js><\/script>');
			</script>
		)
	}

	includeJSFooterlibs {
		/*
		001_google_jquery = //ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js
		001_google_jquery {
			disableCompression = 1
			excludeFromConcatenation = 1
			external = 1
			forceOnTop = 1
		}
		*/
	}
	includeJSFooter {
		foundation = EXT:vantomas/Resources/Public/Javascript/foundation/foundation.js
		foundation_orbit = EXT:vantomas/Resources/Public/Javascript/foundation/foundation.orbit.js
		foundation_section = EXT:vantomas/Resources/Public/Javascript/foundation/foundation.section.js
		fixedNavigation = EXT:vantomas/Resources/Public/Javascript/fixedNavigation.js
	}
	jsFooterInline {
		10 = TEXT
		10.value = $(document).foundation();
	}
}


// -- special setting for SE bots: add noindex meta tag to 
// tx_syntaxhighlight_controller[showTextSource] links
[globalVar = GP:tx_syntaxhighlight_controller|showTextSource > 0]
page.meta.robots = noindex
[global]

[globalString = IENV:QUERY_STRING = id=*]
page.meta.robots = noindex, follow
[global]