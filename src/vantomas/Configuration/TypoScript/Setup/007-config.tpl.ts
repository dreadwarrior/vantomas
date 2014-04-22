config {
	admPanel = 1

	linkVars = L
	uniqueLinkVars = 1

	doctype = html5

	concatenateJs = 1
	concatenateCss = 1
	removeDefaultJS = ${config.removeDefaultJS}
	removeDefaultCss = 1
	compressJs = 1
	compressCss = 1

	spamProtectEmailAddresses_atSubst = @
	no_cache = ${config.no_cache}
	disablePrefixComment = ${config.disablePrefixComment}

	headerComment (
	(c) 2007-2014 Thomas Juhnke
	)

	meaningfulTempFilePrefix = 20

	notification_email_charset = UTF-8

	baseURL = http://${domain}/

	noPageTitle = 2

	metaCharset = utf-8
	renderCharset = utf-8

	language = en
	htmlTag_langKey = en-US
	locale_all = en_US.UTF8
	sys_language_uid = 0
	sys_language_mode = content_fallback
	sys_language_overlay = hideNonTranslated

	simulateStaticDocuments = 0
	tx_realurl_enable = ${config.tx_realurl_enable}
	prefixLocalAnchors = all

	sendCacheHeaders = ${config.sendCacheHeaders}

	moveJsFromHeaderToFooter = 0

	cdn {

		search {
			10 = "atom.xml
			20 = "/fileadmin/
			21 = "fileadmin/
			30 = "/typo3conf/
			31 = "typo3conf/
			40 = "/typo3temp/
			41 = "typo3temp/
		}
		replace {
			http {
				10 = "http://${domain}/atom.xml
				20 = "http://${domain.static.fileadmin}
				21 = "http://${domain.static.fileadmin}
				30 = "http://${domain.static.typo3conf}
				31 = "http://${domain.static.typo3conf}
				40 = "http://${domain.static.typo3temp}
				41 = "http://${domain.static.typo3temp}
			}
			https {
				10 = "https://${domain}/atom.xml
				20 = "https://${domain.static.fileadmin}
				21 = "https://${domain.static.fileadmin}
				30 = "https://${domain.static.typo3conf}
				31 = "https://${domain.static.typo3conf}
				40 = "https://${domain.static.typo3temp}
				41 = "https://${domain.static.typo3temp}
			}
		}
	}
}