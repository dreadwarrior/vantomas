config {
	// Adminpanel aktivieren
	admPanel = 1

	linkVars = L
	uniqueLinkVars = 1

	doctype = html5

	// removeDefaultJS muss deaktiviert werden, wenn z.B. GMENU mit RO benutzt wird
	removeDefaultJS = {$site.defaultJS.disabled}
	minifyJS = 1
	#message_page_is_being_generated = Die von Ihnen angeforderte Seite wird gerade generiert.

	// alle E-Mailadressen werden als Unicode-HTML-Entities umgeschrieben
	#spamProtectEmailAddresses = ascii
	// per Default steht das hier auf (at) - Viele Kunden wünschen jedoch, dass das @ zu sehen
	// ist, also stellen wir das so ein
	spamProtectEmailAddresses_atSubst = @
	#spamProtectEmailAddresses_lastDotSubst = (dot)
	// Notiz: nur zu Testzwecken, in Produktivumgebung zu entfernen/auskommentieren
	no_cache = {$site.cache.disable}
	disablePrefixComment = {$site.prefixComment.disable}

	headerComment (
	(c) 2013 Thomas Juhnke
	)

	// für SEO: fügt n (20) Zeichen den temporären GIFBUILDER-Dateinamen hinzu
	meaningfulTempFilePrefix = 20

	notification_email_charset = UTF-8

	// Notiz: muss für Produktivumgebung angepasst werden
	baseURL = http://{$site.domain.default}/
	// das absRefPrefix bitte nicht benutzen, sondern einen Trailing-Slash in baseURL angeben!
	#absRefPrefix = /

	// Seitentitel ausblenden, kommt aus Seiteneigenschaften->Untertitel
	noPageTitle = 2

	metaCharset = utf-8
	renderCharset = utf-8

	language = en
	htmlTag_langKey = en-US
	locale_all = en_US.UTF8
	sys_language_uid = 0
	sys_language_mode = content_fallback
	sys_language_overlay = hideNonTranslated

	// realURL-Konfiguration
	simulateStaticDocuments = 0
	tx_realurl_enable = {$site.realURL.enable}
	prefixLocalAnchors = all

	// typolinkCheckRootline = 1
	sendCacheHeaders = {$site.cache.sendHeaders}

	moveJsFromHeaderToFooter = 1
}

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