config {
	// Adminpanel aktivieren
	admPanel = 1

	linkVars = L
	uniqueLinkVars = 1

	doctype = html5

	concatenateJs = 1
	concatenateCss = 1
	// removeDefaultJS muss deaktiviert werden, wenn z.B. GMENU mit RO benutzt wird
	removeDefaultJS = {$site.defaultJS.disabled}
	removeDefaultCss = 1
	compressJs = 1
	compressCss = 1
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

	moveJsFromHeaderToFooter = 0

	// custom CDN interceptor
	cdn {
		// search for this strings...
		search {
			10 = "atom.xml
			20 = "/fileadmin/
			21 = "fileadmin/
			30 = "/typo3conf/
			31 = "typo3conf/
			40 = "/typo3temp/
			41 = "typo3temp/
		}
		// ...and replace 'em with the proper protocol-suitable strings
		replace {
			http {
				10 = "http://{$site.domain.default}/atom.xml
				20 = "http://{$domain.static.fileadmin.${environment}}
				21 = "http://{$domain.static.fileadmin.${environment}}
				30 = "http://{$domain.static.typo3conf.${environment}}
				31 = "http://{$domain.static.typo3conf.${environment}}
				40 = "http://{$domain.static.typo3temp.${environment}}
				41 = "http://{$domain.static.typo3temp.${environment}}
			}
			https {
				10 = "https://{$site.domain.default}/atom.xml
				20 = "https://{$domain.static.fileadmin.${environment}}
				21 = "https://{$domain.static.fileadmin.${environment}}
				30 = "https://{$domain.static.typo3conf.${environment}}
				31 = "https://{$domain.static.typo3conf.${environment}}
				40 = "https://{$domain.static.typo3temp.${environment}}
				41 = "https://{$domain.static.typo3temp.${environment}}
			}
		}
	}
}