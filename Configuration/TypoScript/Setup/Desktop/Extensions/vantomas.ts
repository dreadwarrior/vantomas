plugin.tx_vantomas {
	
	settings {
		storagePid = {$plugin.tx_vantomas.settings.storagePid}
		archive {
			searchPid = {$plugin.tx_vantomas.settings.archive.searchPid}
		}
		layout = Desktop

		limit = 5
	}

	view {
		partialRootPath = typo3conf/ext/vantomas/Resources/Private/Partials/
		templateRootPath = typo3conf/ext/vantomas/Resources/Private/Templates/
	}
}