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
		modernizr = EXT:vantomas/Resources/Public/Javascript/vendor/modernizr.min.js
	}

	includeCSS {
		google_fonts = //fonts.googleapis.com/css?family=Neuton|Lobster&amp;subset=latin,latin-ext
		google_fonts {
			disableCompression = 1
			excludeFromConcatenation = 1
			external = 1
			forceOnTop = 1
		}

		foundation_app = EXT:vantomas/Resources/Public/Css/app.css
	}

	includeJSFooter {
		jquery = EXT:vantomas/Resources/Public/Javascript/vendor/jquery.min.js
		fastclick = EXT:vantomas/Resources/Public/Javascript/vendor/fastclick.min.js
		foundation = EXT:vantomas/Resources/Public/Javascript/vendor/foundation.min.js
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