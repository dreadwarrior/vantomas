plugin.tx_perpagecss_pi._CSS_DEFAULT_STYLE (
	#content-inner .csc-default { background-color: #cecece; }
)

lib.gb_transparency = IMAGE
lib.gb_transparency {
	file = GIFBUILDER
	file {
		XY = 543,173
		format = png
		transparentBackground = 1
		transparentColor = #d9d9c9
		backColor = #d9d9c9

		/*
		10 = IMAGE
		10 {
			file = GIFBUILDER
			file {
				XY = 543,173
				format = png

				10 = IMAGE
				10 {
					file = fileadmin/user_upload/gb-transparency/gh-gradient.png
					offset = 0,0
				}
			}
			mask = fileadmin/user_upload/gb-transparency/gh-mask.png
		}
		*/
		10 = IMAGE
		10 {
			file = fileadmin/user_upload/Pipes__Twitter_Map_Search3.jpg
		}
		20 = IMAGE
		20 {
			file = fileadmin/user_upload/gb-transparency/gh-wave.png
			offset = 0,0
		}
		30 = TEXT
		30 {
			text = van-tomas.de Labs
			fontSize = 74
			fontColor = #ffffff
			//fontFile = path/to/LinoTypeZapfinoOne.ttf
			align = center
			offset = 0,77
		}
		40 = TEXT
		40 {
			text = testing ground for TypoScript and Extension development
			fontSize = 17
			fontColor = #87847f
			//fontFile = path/to/ArialNarrow.ttf
			align = center
			offset = 0,123
		}
	}
}