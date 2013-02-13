plugin.tx_vantomas {
	
	settings {
		layout = Desktop

		disqus {
			apiKey = @@@DISQUS_APIKEY@@@
			// leave empty to use built-in default
			baseUrl = 
		}
	}

	view {
		partialRootPath = typo3conf/ext/vantomas/Resources/Private/Partials/
		templateRootPath = typo3conf/ext/vantomas/Resources/Private/Templates/
	}
}