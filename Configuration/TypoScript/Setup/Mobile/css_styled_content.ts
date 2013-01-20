// -- cleanup some css_styled_content wraps
// header stdWrap
lib.stdheader.stdWrap.dataWrap >
// translated content anchor pre-wrap
tt_content.stdWrap.prepend >
// innerwrap for tt_content elements (including frame-settings)
tt_content.stdWrap.innerWrap.cObject.default >

// ...
tt_content.menu.20.1.wrap = <ul data-role="listview" data-inset="true">|</ul>

// -- jQuery mobile compatible setup for "subpages with abstract"
tt_content.menu.20.4.wrap = <div data-role="collapsible-set">|</div>

tt_content.menu.20.4.1.alternativeSortingField = lastUpdated desc
tt_content.menu.20.4.1.maxItems = 5

tt_content.menu.20.4.1.NO.after >
tt_content.menu.20.4.1.NO.before.cObject = COA
tt_content.menu.20.4.1.NO.before.cObject {
	10 = TEXT
	10 {
		field = nav_title // title
		wrap = <h3>|</h3>
	}
	20 = TEXT
	20 {
		data = field:abstract // field:description // field:subtitle
		required = 1
		htmlSpecialChars = 0
		parseFunc =< lib.parseFunc_RTE
	}
	wrap = <div data-role="collapsible" data-collapsed="true">|
}
tt_content.menu.20.4.1.NO.linkWrap = |</div>
tt_content.menu.20.4.1.NO.stdWrap.override = read more
tt_content.menu.20.4.1.NO.ATagParams = data-role="button" data-icon="arrow-r" data-iconpos="right" data-theme="b"
