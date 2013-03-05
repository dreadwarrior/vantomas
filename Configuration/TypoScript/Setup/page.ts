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
}


// -- special setting for SE bots: add noindex meta tag to 
// tx_syntaxhighlight_controller[showTextSource] links
[globalVar = GP:tx_syntaxhighlight_controller|showTextSource > 0]
page.meta.robots = noindex
[global]

[globalString = IENV:QUERY_STRING = id=*]
page.meta.robots = noindex, follow
[global]