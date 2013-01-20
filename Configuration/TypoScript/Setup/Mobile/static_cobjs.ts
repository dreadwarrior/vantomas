lib.static {
	// clear out page abstract
	page_abstract = TEXT
	page_abstract.value = 

	mobile_header_button_right = COA
	mobile_header_button_right {
		10 = TEXT
		10 {
			value = Options
			typolink {
				parameter = 227
				ATagParams = data-icon="gear" data-rel="dialog" data-theme="b" class="ui-btn-right"
			}
		}
	}
	
	mobile_footer = COA
	mobile_footer {
		/*
		10 = TEXT
		10 {
			value = <a href="#jqm-home" data-role="button" data-icon="arrow-u">Up</a>
			wrap = <div data-role="controlgroup" data-type="horizontal">|</div>
		}
		*/
		20 = COA
		20 {
			10 = COA
			10 {
				wrap = <ul>|</ul>
				10 = TEXT
				10 {
					typolink.parameter = 221
					typolink.ATagParams = data-icon="grid"
					wrap = <li>|</li>
				}
				20 = TEXT
				20 {
					typolink.parameter = 225
					typolink.ATagParams = data-icon="plus"
					wrap = <li>|</li>
				}
				30 = TEXT
				30 {
					typolink.parameter = 223
					typolink.ATagParams = data-icon="check"
					wrap = <li>|</li>
				}
				40 = TEXT
				40 {
					typolink.parameter = 224
					typolink.ATagParams = data-icon="info"
					wrap = <li>|</li>
				}
			}
			wrap = <div data-role="navbar">|</div>
		}
	}

	# -- sidebar archive list
	archive_list = CONTENT
	archive_list {
		select {
			pidInList = 143
			orderBy = lastUpdated DESC
			groupBy = ym
			where = nav_hide = 0
			selectFields = *, DATE_FORMAT(FROM_UNIXTIME(lastUpdated), '%Y-%m') ym
		}
		table = pages
		renderObj = TEXT
		renderObj {
			#field = subtitle // title
			field = lastUpdated // crdate
			strftime = %B %Y

			typolink {
				parameter = 222
				additionalParams {
					cObject = TEMPLATE
					cObject {
						template = TEXT
						template.value = &archive[month]=###MONTH###&archive[year]=###YEAR###
						marks {
							MONTH = TEXT
							MONTH {
								field = lastUpdated // crdate
								strftime = %m
							}
							YEAR = TEXT
							YEAR {
								field = lastUpdated // crdate
								strftime = %Y
							}
						}
					}
				}
			}
			wrap = <li>|</li>
		}
		stdWrap.wrap = <ul data-role="listview" data-theme="g">|</ul>
	}

	# -- archive month/year query list
	query_archive = COA_INT
	query_archive {
		10 = CONTENT
		10 {
			select {
				pidInList = 143
				orderBy = lastUpdated DESC
				where = nav_hide = 0
				#selectFields = ()/*
				andWhere {
					cObject = TEMPLATE
					cObject {
						template = TEXT
						template.value = lastUpdated BETWEEN UNIX_TIMESTAMP('###YEAR###-###MONTH###-01 00:00:01') AND UNIX_TIMESTAMP(CONCAT(LAST_DAY('###YEAR###-###MONTH###-01'), ' 23:59:59'))
						marks {
							YEAR = TEXT
							YEAR {
								data = GP:archive|year
								intval = 1
								removeBadHTML = 1
								stripHtml = 1
							}
							MONTH = TEXT
							MONTH {
								data = GP:archive|month
								#intval = 1
								removeBadHTML = 1
								stripHtml = 1
							}
						}
					}
				}
			}
			table = pages
			renderObj = COA_INT
			renderObj {
				10 = TEXT
				10 {
					field = subtitle // title
					wrap = <h3>|</h3>
				}
				#20 = TEXT
				#20.value = <br />
				40 = TEXT
				40 {
					field = abstract
					cropHTML = 255|...|1

					parseFunc = < lib.parseFunc_RTE
				}
				45 = TEXT
				45 {
					field = lastUpdated
					#date = jS F Y
					date = F jS, Y
					wrap = <p class="ui-li-aside">|</p>
				}
				stdWrap.typolink.parameter.field = uid
				stdWrap.typolink.parameter.additionalParams = &MP=143-219

				stdWrap.wrap (
				<li data-theme="c">|</li>
				
				)
			}
			wrap = <ul data-role="listview" data-split-theme="a">|</ul>
		}
	}
}
