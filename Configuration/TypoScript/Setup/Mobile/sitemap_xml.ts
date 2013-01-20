google_sitemap = PAGE
google_sitemap {
	typeNum = 666
	config {
		admPanel = 0
		xhtml_cleaning =
		disableAllHeaderCode = 1
		additionalHeaders = Content-Type: text/xml
		simulateStaticDocuments = 0
		baseURL = http://mobile.van-tomas.de
		tx_realurl_enable = 1
	}

	10 = COA
	10 {
		10 = HMENU
		10 {
			special = directory
			special.value = 136,143

			excludeDoktypes = 6
				# "Standard-Seitenleisten-Boxen"
			#excludeUidList = 47

			stdWrap.noTrimWrap (
				|<?xml version="1.0" encoding="UTF-8"?>
				<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
					xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">
					|
				</urlset>|
			)
			1 = TMENU
			1 {
				expAll = 1
				NO {
					doNotLinkIt = 1
					allWrap (
						<url>
							|
						</url>

					)
					stdWrap.cObject = COA
					stdWrap.cObject {
						10 = TEXT
						10 {
							typolink {
								parameter.field = uid
								returnLast = url
							}
							wrap (
								<loc>http://mobile.van-tomas.de|</loc>
								<mobile:mobile />
							)
						}
						20 = TEXT
						20 {
							#SYS_LASTCHANGED //
							field = lastUpdated
							override {
								field = crdate
								if.isFalse.field = lastUpdated
							}
							strftime = %Y-%m-%dT%H:%M:%SZ
							wrap (
								<lastmod>|</lastmod>
							)
						}
					}
				}
			}
			2 < .1
			3 < .1
			4 < .1
			5 < .1
			6 < .1
			7 < .1
			8 < .1
			9 < .1
			10 < .1
		}
	}
}
