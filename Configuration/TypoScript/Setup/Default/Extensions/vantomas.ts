plugin.tx_vantomas {
	persistence {
		classes {
			Tx_Vantomas_Domain_Model_Page {
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
}