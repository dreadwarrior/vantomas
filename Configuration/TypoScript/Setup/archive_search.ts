# title Tag adjustments for the search results
page.headerData.10 {
	postCObject = COA_INT
	postCObject {
		10 = TEMPLATE
		10 {
			template = TEXT
			template {
				value = for ###YEAR###/###MONTH###
				noTrimWrap = | ||
			}
			marks {
				MONTH = TEXT
				MONTH {
					data = GP:tx_vantomas_archivesearch|month
					removeBadHTML = 1
				}
				YEAR = TEXT
				YEAR {
					data = GP:tx_vantomas_archivesearch|year
					removeBadHTML = 1
				}
			}
		}
	}
}