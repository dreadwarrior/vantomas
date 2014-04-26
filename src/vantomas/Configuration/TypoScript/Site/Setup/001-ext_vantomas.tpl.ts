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
		twitter {
			consumerKey = ${twitter.consumerKey}
			consumerSecret = ${twitter.consumerSecret}

			bearerTokenUrl = https://api.twitter.com/oauth2/token

			userAgent = van-tomas.de Twitter App v1.0
			bearerCacheLifetime = 86400
		}

		mailer {
			DreadLabs\Vantomas\Mailer\ContactForm {
				sender {
					1 {
						mail = ${mailer.contactform.sender.mail}
						name = ${mailer.contactform.sender.name}
					}
				}
				receiver {
					1 {
						mail = ${mailer.contactform.receiver.mail}
						name = ${mailer.contactform.receiver.name}
					}
				}
			}
		}
		
		rss {
			enableFeedImage = 0
			startPid = 143
		}
		
		sitemap {
			pids {
				home = 136
				blog = 143
			}
			excludeUids {
				grsp = 161
				blog = 143
				labs = 142
				internal = 137
			}
		}
	}

	view {
		partialRootPath = EXT:vantomas/Resources/Private/Partials/
		templateRootPath = EXT:vantomas/Resources/Private/Templates/
		layoutRootPath = EXT:vantomas/Resources/Private/Layouts/
	}
}