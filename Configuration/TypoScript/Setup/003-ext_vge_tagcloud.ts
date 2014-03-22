plugin.tx_vgetagcloud_pi1 {
	cloudWrap.wrap = |
	
	tagWrap {
		dataWrap = <span style="font-size: {field:tag_style}%;">|</span>
		//dataWrap = |
		// add additional space after link to have proper line breaks in browsers
		noTrimWrap = || |
		typolink {
			ATagParams {
				cObject {
					dataWrap = id="tag{field:tag_id}" title="|" rel="nofollow tag"
				}
			}
		}
	}

	_CSS_DEFAULT_STYLE >
}

plugin.tx_vgetagcloud_pi2 {
	message.wrap = <p class="bodytext">|</p>

	#results < lib.static.archive_query

	results = HMENU
	results {
		special = list
		special.value.field = tag_pages

		1 = TMENU
		1 {
			NO.allWrap = <li>|</li>
			#NO {
				#stdWrap.override.cObject =< lib.static.query_archive.renderObj
			#}
		}
		wrap = <ul>|</ul>
	}
}