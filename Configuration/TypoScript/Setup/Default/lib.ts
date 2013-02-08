lib.abstractImage = IMAGE
lib.abstractImage {
	file = GIFBUILDER
	file {
		XY = [10.w],[10.h]
		10 = IMAGE
		10 {
			file.import = uploads/media/
			file.import.data = page:media
		}

		20 = IMAGE
		20.file = EXT:vantomas/Resources/Public/Images/Desktop/folded-paper.png

		30 = IMAGE
		30 {
			file = EXT:vantomas/Resources/Public/Images/Desktop/grunge.png
			offset = 0,-5
		}
	}

	altText.data = page:subtitle // page:title
	titleText.data = page:subtitle // page:title
}

lib.abstractImageLastUpdated = IMAGE
lib.abstractImageLastUpdated {
	file = GIFBUILDER
	file {
		XY = [10.w],[10.h]
		10 = IMAGE
		10 {
			file.import = uploads/media/
			file.import.field = media
		}

		20 = IMAGE
		20.file = EXT:vantomas/Resources/Public/Images/Desktop/folded-paper.png

		30 = IMAGE
		30 {
			file = EXT:vantomas/Resources/Public/Images/Desktop/grunge.png
			offset = 0,-5
		}
	}

	altText.field = subtitle // title
	titleText.field = subtitle // title
}