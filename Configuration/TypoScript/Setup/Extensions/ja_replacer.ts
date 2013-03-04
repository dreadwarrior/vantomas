// Welche Links sollen ersetzt werden? (jeweils mit und ohne Slash am Anfang)
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
	10 = "http://www.van-tomas.de/atom.xml
	20 = "http://static1.van-tomas.de/
	21 = "http://static1.van-tomas.de/
	30 = "http://static2.van-tomas.de/
	31 = "http://static2.van-tomas.de/
	40 = "http://static3.van-tomas.de/
	41 = "http://static3.van-tomas.de/
}

// Mit was soll ersetzt werden, wenn im sicheren Bereich (https)
/*
tx_ja_replacer.secure = COA
tx_ja_replacer.secure {
	20 = "https://static.van-tomas.de/typo3temp/
	21 = "https://static.van-tomas.de/typo3temp/
	22 = "https://static.van-tomas.de/fileadmin/
	23 = "https://static.van-tomas.de/fileadmin/
	24 = "https://static.van-tomas.de/typo3conf/
	25 = "https://static.van-tomas.de/typo3conf/
}
*/

// -- Domain Setup:
[globalString = ENV:HTTP_HOST = www.van-tomas.de]
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