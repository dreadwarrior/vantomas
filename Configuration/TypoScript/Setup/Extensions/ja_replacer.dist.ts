// Welche Links sollen ersetzt werden? (jeweils mit und ohne Slash am Anfang)
/*
config.tx_ja_replacer.search {
	10 = "atom.xml
	20 = "/fileadmin/
	21 = "fileadmin/
	30 = "/typo3conf/
	31 = "typo3conf/
	40 = "/typo3temp/
	41 = "typo3temp/
}

// Mit was soll ersetzt werden, wenn im unsicheren Bereich (http)
tx_ja_replacer.unsecure = COA
tx_ja_replacer.unsecure {
	10 = "http://{$site.domain.default}/atom.xml
	20 = "http://@@@DOMAIN_STATIC_FILEADMIN@@@
	21 = "http://@@@DOMAIN_STATIC_FILEADMIN@@@
	30 = "http://@@@DOMAIN_STATIC_TYPO3CONF@@@
	31 = "http://@@@DOMAIN_STATIC_TYPO3CONF@@@
	40 = "http://@@@DOMAIN_STATIC_TYPO3TEMP@@@
	41 = "http://@@@DOMAIN_STATIC_TYPO3TEMP@@@
}
*/

// Mit was soll ersetzt werden, wenn im sicheren Bereich (https)
/*
tx_ja_replacer.secure = COA
tx_ja_replacer.secure {
	20 = "https://@@@DOMAIN_STATIC_FILEADMIN@@@
	21 = "https://@@@DOMAIN_STATIC_FILEADMIN@@@
	22 = "https://@@@DOMAIN_STATIC_TYPO3CONF@@@
	23 = "https://@@@DOMAIN_STATIC_TYPO3CONF@@@
	24 = "https://@@@DOMAIN_STATIC_TYPO3TEMP@@@
	25 = "https://@@@DOMAIN_STATIC_TYPO3TEMP@@@
}
*/

// -- Domain Setup:
[globalString = ENV:HTTP_HOST = {$site.domain.default}]
	// -- Normalfall, wird statisch gecached
	// page.config.baseURL = http://{$site.domain.default}/
	config.tx_ja_replacer.replace < tx_ja_replacer.unsecure
[global]

/*
[globalString = ENV:HTTP_HOST = www.domain.com] && [globalString = _SERVER|HTTPS=on]
	page.config.baseURL = https://www.domain.com/
	config.tx_ja_replacer.replace < tx_ja_replacer.secure
[global]
*/