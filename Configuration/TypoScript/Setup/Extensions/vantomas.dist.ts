plugin.tx_vantomas {
	persistence {
		classes {
			DreadLabs\Vantomas\Domain\Model\Page {
				mapping {
					tableName = pages
					// sets page.doktype = 'Tx_Vantomas_Domain_Model_Page' in query string
					//recordType = Tx_Vantomas_Domain_Model_Page
					columns {
						uid.mapOnProperty = uid
						pid.mapOnProperty = pid
						nav_hide.mapOnProperty = hideInNavigation
						title.mapOnProperty = title
						subtitle.mapOnProperty = subtitle
						lastUpdated.mapOnProperty = lastUpdated
						crdate.mapOnProperty = creationDate
						abstract.mapOnProperty = abstract
						media.mapOnProperty = media
						keywords.mapOnProperty = keywords
					}
				}
			}
		}
	}
	
	settings {
		disqus {
			apiKey = @@@DISQUS_APIKEY@@@
			// leave empty to use built-in default
			baseUrl = 
			client = curl
		}
	}

	view {
		partialRootPath = typo3conf/ext/vantomas/Resources/Private/Partials/
		templateRootPath = typo3conf/ext/vantomas/Resources/Private/Templates/
	}
}