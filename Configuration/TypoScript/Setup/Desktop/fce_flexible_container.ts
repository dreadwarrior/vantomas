lib.fce.flexible_container {
	renderObj = COA
	renderObj {
		10 = COA
		10 {
			10 = TEXT
			10.field = field_id
			10.noTrimWrap = | id="|"|
			10.if.isTrue.field = field_id
			20 = TEXT
			20.field = field_class
			20.noTrimWrap = | class="|"|
			20.if.isTrue.field = field_class

			wrap = <div|>
		}
		30 = RECORDS
		30 {
			source.field = field_content
			tables = tt_content
		}
		40 = TEXT
		40.value = </div>
	}
}
