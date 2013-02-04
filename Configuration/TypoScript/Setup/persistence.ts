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
			/*
			Tx_Vantomas_Domain_Model_GenericCounter {
				mapping {
					tableName = tx_cscounterplus_info
					columns {
						//uid.mapOnProperty = uid
						//pid.mapOnProperty = pid
						cid.mapOnProperty = counterId
						visits.mapOnProperty = numberOfVisits
						tstamp.mapOnProperty = timestamp
					}
				}
			}
			*/
			Tx_Vantomas_Domain_Model_Comment {
				mapping {
					tableName = tx_comments_comments
					columns {
						uid.mapOnProperty = uid
						pid.mapOnProperty = pid
						approved.mapOnProperty = approved
						external_ref.mapOnProperty = externalReference
						external_prefix.mapOnProperty = externalPrefix
						firstname.mapOnProperty = firstname
						lastname.mapOnProperty = lastname
						email.mapOnProperty = email
						homepage.mapOnProperty = homepage
						content.mapOnProperty = content
					}
				}
			}
		}
	}
}
