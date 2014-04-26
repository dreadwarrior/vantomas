sitemap_xml = PAGE
sitemap_xml {
	config {
		admPanel = 0
		xhtml_cleaning =
		disableAllHeaderCode = 1
		additionalHeaders = Content-Type: text/xml
		simulateStaticDocuments = 0
		baseURL = http://${domain}/
		tx_realurl_enable = 1
	}

	typeNum = 666
	
	10 = USER
	10 {
		userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
		vendorName = DreadLabs
		extensionName = Vantomas
		pluginName = SitemapXml

		stdWrap.trim = 1
	}
}