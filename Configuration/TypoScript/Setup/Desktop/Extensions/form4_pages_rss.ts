includeLibs.form4_pages_rss = EXT:form4_pages_rss/pi1/class.tx_form4_pages_rss_pi1.php

# -- generate the Feed
feed = PAGE
feed {
	config{
		disableAllHeaderCode = 1
		disableCharsetHeader = 1
		additionalHeaders = Content-type:text/xml
		no_cache = 1
		xhtml_cleaning = 0
		admPanel = 0
	}

	typeNum = 103

	10 = USER
	10 {
		userFunc = tx_form4_pages_rss_pi1->main
		feedPid = 228
		item {
			title = title
			description = abstract
			author = author_email
			pubDate = crdate
		}
	}
}

# -- declare Feed in the frontend (ATOM)
page {
	headerData {
		12 = TEXT
		12.value = <link rel="alternate" type="application/rss+xml" title="TYPO3, Ubuntu, Open Source" href="/atom.xml" />
	}
}
