// -- ext:css_styled_content

// -- lib.parseFunc* configuration

// common parsed elements (e.g.header fields)
lib.parseFunc.allowTags := addToList(star)
//lib.parseFunc.tags.star = < plugin.tx_mycustomtagextension_pi1
//lib.parseFunc.nonTypoTagStdWrap.HTMLparser.tags.star = < plugin.tx_mycustomtagextension_pi1
lib.parseFunc.tags.star = < lib.custom_tags.stars
lib.parseFunc.nonTypoTagStdWrap.HTMLparser.tags.star = < lib.custom_tags.stars

// add custom tag to parse function of the RTE
lib.parseFunc_RTE.allowTags := addToList(star)
//lib.parseFunc_RTE.tags.star = < plugin.tx_mycustomtagextension_pi1
lib.parseFunc_RTE.tags.star = < lib.custom_tags.stars
// this line enables the "passthrough" of non-typo-tags to the HTML parser
// you can also specify an cObject directly, without the need of a plugin call
//lib.parseFunc_RTE.nonTypoTagStdWrap.HTMLparser.tags.star = < plugin.tx_mycustomtagextension_pi1
lib.parseFunc_RTE.nonTypoTagStdWrap.HTMLparser.tags.star = < lib.custom_tags.stars

// -- tt_content / lib.stdheader config

// here you also can use your TypoScript cObject
//tt_content.text.20.parseFunc.tags.star = < plugin.tx_mycustomtagextension_pi1
tt_content.text.20.parseFunc.tags.star = < lib.custom_tags.stars

// header fields don't have any parseFunc setup, enable it!
lib.stdheader.10.setCurrent.parseFunc =< lib.parseFunc
// by default all input is parsed with stdWrap.htmlSpecialChars
lib.stdheader.10.setCurrent.htmlSpecialChars = 0

// -- TS plugin: custom tags (stars)

lib.custom_tags {
	stars = CASE
	stars {
		// all tag params will be stored in internal params array of cObj
		key.data = parameters:theme

		// yellow stars
		1 = IMAGE
		1 {
			file = GIFBUILDER
			file {
				XY = {$custom_tags.stars.theme.1.width}*{$custom_tags.stars.repetitionX},{$custom_tags.stars.theme.1.height}*{$custom_tags.stars.repetitionY}
				backColor = {$custom_tags.stars.theme.1.backColor}
				10 = IMAGE
				10 {
					file = {$custom_tags.stars.theme.1.file}
					file {
						width = {$custom_tags.stars.theme.1.width}c
						height = {$custom_tags.stars.theme.1.height}c
					}
					tile = {$custom_tags.stars.repetitionX},{$custom_tags.stars.repetitionY}
				}
			}
			params = class="custom-tags-stars"
			altText {
				// value of tag-wrapped text, e.g. <star>my alt text</star>
				current = 1
				htmlSpecialChars = 1
			}
		}
		
		// blue stars
		2 < .1
		2 {
			file {
				XY = {$custom_tags.stars.theme.2.width}*{$custom_tags.stars.repetitionX},{$custom_tags.stars.theme.2.height}*{$custom_tags.stars.repetitionY}
				backColor = {$custom_tags.stars.theme.2.backColor}
				10 {
					file = {$custom_tags.stars.theme.2.file}
					file {
						width = {$custom_tags.stars.theme.2.width}c
						height = {$custom_tags.stars.theme.2.height}c
					}
				}
			}
		}

		// yellow stars but with repetition variation
		3 < .1
		3 {
			// note how the constants are replaced by a fixed repetition value
			file.XY = {$custom_tags.stars.theme.1.width}*3,{$custom_tags.stars.theme.1.height}*1
			file.10.tile = 3,1
		}

		// yellow stars with hotel categorization addon
		4 < .1
		4 {
			file {
				// here we use a theme specific width, because to face
				// possible sizing changes, additionally, the width of
				// the GIFBUILDER TEXT object is added ([20.w]) and the
				// small offset of the text (3)
				XY = {$custom_tags.stars.theme.4.width}*{$custom_tags.stars.repetitionX}+[20.w]+3,{$custom_tags.stars.theme.4.height}*{$custom_tags.stars.repetitionY}

				20 = TEXT
				20 {
					text = {$custom_tags.stars.theme.4.text}
					fontSize = {$custom_tags.stars.theme.4.fontSize}
					fontColor = {$custom_tags.stars.theme.4.fontColor}
					fontFile = {$custom_tags.stars.theme.4.fontFile}
					offset = [10.w]*{$custom_tags.stars.repetitionX}+3,11
				}
			}
		}

		// if no theme was specified, do nothing but print out the tag-wrapped text
		default = TEXT
		default {
			current = 1
		}
	}
}
