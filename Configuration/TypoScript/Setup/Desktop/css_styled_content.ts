# Quelle: http://www.site42.de/Wie-konfiguriert-man-den-RTE-h.58.0.html

# rtehtmlarea FAQ 3.10: damit wird class="contenttable" nur gesetzt, wenn kein class-Attribut für die Tabelle angegeben wurde
lib.parseFunc_RTE.externalBlocks.table.stdWrap.HTMLparser.tags.table.fixAttrib.class.list >
# avoid unwanted p-elements in th/td on the way to FE
lib.parseFunc_RTE.externalBlocks.table.HTMLtableCells.default >
lib.parseFunc_RTE.externalBlocks.table.HTMLtableCells.default.stdWrap.parseFunc =< lib.parseFunc

# -- benutzerdefinierte Tags zur parseFunc für normale Felder hinzufügen

lib.parseFunc.allowTags := addToList(star)
lib.parseFunc.tags.star = < plugin.user_tagstar_pi1
lib.parseFunc.nonTypoTagStdWrap.HTMLparser.tags.star = < plugin.user_tagstar_pi1

# -- benutzerdefinierte Tags zur parseFunc für Felder mit RTE hinzufügen

lib.parseFunc_RTE.allowTags := addToList(star)
lib.parseFunc_RTE.tags.star = < plugin.user_tagstar_pi1

# erst diese Anweisung lässt benutzerdefinierte Elemente "durch"
# man könnte auch direkt hier ein TypoScript-Objekt übergeben, ohne Plugin-Call
lib.parseFunc_RTE.nonTypoTagStdWrap.HTMLparser.tags.star = < plugin.user_tagstar_pi1

# -- Überschriftenkonfiguration

# damit die Redakteure die Möglichkeit haben die Überschriften umbrechen zu lassen, binden
# wir dieses Standard-TypoScript-Setup ein. An dieser Stelle können ebenfalls lib.stdheader.*-Einstellungen
# vorgenommen werden, um grafische Überschriften zu generieren
lib.stdheader.10 {
	1 {
		split {
			token = |
			cObjNum = 1 |*| 1 |*| 2
			1 {
				current = 1
				#htmlSpecialChars = 1
				wrap = |<br />
			}
			2 {
				current = 1
				#htmlSpecialChars = 1
			}
		}
	}
	2 {
		split {
			token = |
			cObjNum = 1 |*| 1 |*| 2
			1 {
				current = 1
				#htmlSpecialChars = 1
				wrap = |<br />
			}
			2 {
				current = 1
				#htmlSpecialChars = 1
			}
		}
	}
	3 {
		split {
			token = |
			cObjNum = 1 |*| 1 |*| 2
			1 {
				current = 1
				#htmlSpecialChars = 1
				wrap = |<br />
			}
			2 {
				current = 1
				#htmlSpecialChars = 1
			}
		}
	}
	4 {
		split {
			token = |
			cObjNum = 1 |*| 1 |*| 2
			1 {
				current = 1
				#htmlSpecialChars = 1
				wrap = |<br />
			}
			2 {
				current = 1
				#htmlSpecialChars = 1
			}
		}
	}
	5 {
		split {
			token = |
			cObjNum = 1 |*| 1 |*| 2
			1 {
				current = 1
				#htmlSpecialChars = 1
				wrap = |<br />
			}
			2 {
				current = 1
				#htmlSpecialChars = 1
			}
		}
	}
}

# -- wenn in Überschriften auch benutzerdefinierte Tags erlaubt sein sollen,
#		ist folgendes TS notwendig:
lib.stdheader.10.setCurrent.parseFunc =< lib.parseFunc
lib.stdheader.10.setCurrent.htmlSpecialChars = 0

# -- Anpassungen für Zuschneiden "Effekt" bei Bildern

tt_content.image.20 {
	1 {
		file {
			width {
				# crop-Parameter an Breitenangabe anhängen...
				append = TEXT
				append {
					value = c
					# wenn Zuschneiden-Effekt ausgewählt wurde
					if.equals.field = image_effects
					if.value = 30
				}
			}
			# height Parameter erstellen...
			height {
				# ...wird hier ausgelesen
				field = imageheight

				# ...crop-Parameter anhängen
				append = TEXT
				append {
					value = c
				}

				# das alles nur, wenn "Zuschneiden" Effekt ausgewählt wurde
				if.equals.field = image_effects
				if.value = 30
			}
		}
	}
	equalH {
		# equalH bekommt eine Bedingung: und zwar wird dieser Parameter
		# nur gesetzt, wenn das bei Effekte nicht "Zuschneiden" ausgewählt
		# wurde
		if.equals.field = image_effects
		if.value = 30
		if.negate = 1
	}
}

# -- neuer Menütyp "kürzlich aktualisierte Seiten" mit
# special.mode und special.limit Einstellung
tt_content.menu.20 {
	8 = HMENU
	8 {
		special = directory
		special {
			value.field = pages
			#mode = crdate
			//#mode = lastUpdated
			#limit = 2
			//maxAge >
			#maxAge = 3600*24*365
			#excludeNoSearchPages = 0
		}
		wrap = |
		# TMENU
		1 = TMENU
		1 {
			alternativeSortingField = lastUpdated desc
			maxItems = 2
			NO {
				wrapItemAndSub = <div class="post-item">|</div>
				linkWrap = <h1 class="csc-firstHeader">|</h1>
				after {
					cObject = COA
					cObject {
						10 = TEXT
						10 {
							cObject = COA
							cObject {
								# e.g. 24th march 2010
								10 = TEXT
								10 {
									field = lastUpdated
									#date = jS F Y
									date = F jS, Y
								}
								15 = TEXT
								15.value = •
								15.noTrimWrap = | | |
								20 = TEXT
								20.field = keywords
								25 = TEXT
								25.value = •
								25.noTrimWrap = | | |
								# link to comments part
								30 = TEXT
								30.value = comments
								30.typolink {
									parameter.field = uid
									section = comment-list
								}
							}
							wrap = <div class="post-item-meta">|</div>
						}
						20 = COA
						20 {
							10 = IMAGE
							10 {
								file = GIFBUILDER
								file {
									XY = [10.w],[10.h]
									10 = IMAGE
									10 {
										file.import = uploads/media/
										file.import.field = media
									}
									20 = IMAGE
									20 {
										file = fileadmin/templates/van-tomas.de/img/folded-paper.png
									}
									30 = IMAGE
									30 {
										file = fileadmin/templates/van-tomas.de/img/grunge.png
										offset = 0,-5
									}
								}
								altText.data = page:subtitle // page:title
								titleText.data = page:subtitle // page:title
								wrap = <div class="csc-textpic-border">|</div>
							}
							20 = TEXT
							20 {
								field = abstract
								parseFunc = < lib.parseFunc_RTE
								#wrap = <p class="bodytext">|</p>
							}
							wrap = <div class="content">|</div>
						}
						30 = TEXT
						30 {
							wrap = <ul class="post-item-actions"><li>|</li></ul>
							value = read more »
							typolink.parameter.field = uid
							typolink.ATagParams = class="round"
						}
					}
				}
			}
		}
	}
}

// -- verbesserte HTML-Struktur für CE Up-/Downloadliste
tt_content.uploads {
	20 {
		// @todo: insert class according to selected layout (csc-uploads-{field:layout})
		outerWrap = <dl class="csc-uploads">|</dl>
		itemRendering {
			// file type icon
			10 {
				wrap = <dt class="csc-uploads-icon">|</dt>
				// otherwise, this item only gets rendered
				// if field:layout > 0
				if >
			}
			// label & description
			20 {
				wrap = <dd class="csc-uploads-fileName">|</dd>
				1.wrap = <p class="bodytext">|</p>
				2.wrap = <p class="bodytext csc-uploads-description">|</p>
			}
			// file size
			30 {
				wrap = <dd class="csc-uploads-fileSize"><p class="bodytext">|</p></dd>
			}
			40 = TEXT
			40 {
				value = <!-- -->
				wrap = <dd class="csc-uploads-itemSeparator">|</dd>
			}

			// no need for the <tr> elements here...
			wrap >
		}
		linkProc {
			// no _blank please!
			target >		
		}
	}
}

tt_content.swfobject.20.layout {
	// dataWrap = <div style="width: {field:width}px; height: {field:height}px;">|</div>
}

tt_content.media.20.mimeConf.swfobject.layout {
	// dataWrap = <div style="width: {data:flexParams|width}px; height: {data:flexParams|height}px;">|</div>
	// debug = 1
}

# -- css_styled_content CSS
/*
plugin.tx_cssstyledcontent_pi1 {
	# Anpassungen am Standard-CSS
	_CSS_DEFAULT_STYLE (
	/* Captions */
	DIV.csc-textpic-caption-c .csc-textpic-caption { text-align: center; }
	DIV.csc-textpic-caption-r .csc-textpic-caption { text-align: right; }
	DIV.csc-textpic-caption-l .csc-textpic-caption { text-align: left; }

	/* Needed for noRows setting */
	DIV.csc-textpic DIV.csc-textpic-imagecolumn { float: left; display: inline; }

	/* Border just around the image */
	{$styles.content.imgtext.borderSelector} {
		border: {$styles.content.imgtext.borderThick}px solid {$styles.content.imgtext.borderColor};
		padding: {$styles.content.imgtext.borderSpace}px {$styles.content.imgtext.borderSpace}px;
	}

	DIV.csc-textpic-imagewrap { padding: 0; }

	DIV.csc-textpic IMG { border: none; }

	/* DIV: This will place the images side by side */
	DIV.csc-textpic DIV.csc-textpic-imagewrap DIV.csc-textpic-image { float: left; }

	/* UL: This will place the images side by side */
	DIV.csc-textpic DIV.csc-textpic-imagewrap UL { list-style: none; margin: 0; padding: 0; }
	/* #wrap DIV.csc-textpic DIV.csc-textpic-imagewrap UL { list-style: none; margin: 0; padding: 0; } */
	DIV.csc-textpic DIV.csc-textpic-imagewrap UL LI { float: left; margin: 0; padding: 0; } 
	/* #wrap DIV.csc-textpic DIV.csc-textpic-imagewrap UL LI { float: left; margin: 0; padding: 0; } */

	/* DL: This will place the images side by side */
	DIV.csc-textpic DIV.csc-textpic-imagewrap DL.csc-textpic-image { float: left; }
	DIV.csc-textpic DIV.csc-textpic-imagewrap DL.csc-textpic-image DT { float: none; }
	DIV.csc-textpic DIV.csc-textpic-imagewrap DL.csc-textpic-image DD { float: none; }
	DIV.csc-textpic DIV.csc-textpic-imagewrap DL.csc-textpic-image DD IMG { border: none; } /* FE-Editing Icons */
	DL.csc-textpic-image { margin: 0; }
	DL.csc-textpic-image DT { margin: 0; display: inline; }
	DL.csc-textpic-image DD { margin: 0; }

	/* Clearer */
	DIV.csc-textpic-clear { clear: both; }

	/* Margins around images: */

	/* Pictures on left, add margin on right */
	DIV.csc-textpic-left DIV.csc-textpic-imagewrap .csc-textpic-image,
	DIV.csc-textpic-intext-left-nowrap DIV.csc-textpic-imagewrap .csc-textpic-image,
	DIV.csc-textpic-intext-left DIV.csc-textpic-imagewrap .csc-textpic-image {
		display: inline; /* IE fix for double-margin bug */
		margin-right: {$styles.content.imgtext.colSpace}px;
	}

	/* Pictures on right, add margin on left */
	DIV.csc-textpic-right DIV.csc-textpic-imagewrap .csc-textpic-image,
	DIV.csc-textpic-intext-right-nowrap DIV.csc-textpic-imagewrap .csc-textpic-image,
	DIV.csc-textpic-intext-right DIV.csc-textpic-imagewrap .csc-textpic-image {
		display: inline; /* IE fix for double-margin bug */
		margin-left: {$styles.content.imgtext.colSpace}px;
	}

	/* Pictures centered, add margin on left */
	DIV.csc-textpic-center DIV.csc-textpic-imagewrap .csc-textpic-image {
		display: inline; /* IE fix for double-margin bug */
		margin-left: {$styles.content.imgtext.colSpace}px;
	}
	DIV.csc-textpic DIV.csc-textpic-imagewrap .csc-textpic-image .csc-textpic-caption { margin: 10px 0 0 0; line-height: 1.25em; font-size: 0.9em; font-style: italic; }
	DIV.csc-textpic DIV.csc-textpic-imagewrap .csc-textpic-image IMG { margin: 0; }

	/* Space below each image (also in-between rows) */
	DIV.csc-textpic DIV.csc-textpic-imagewrap .csc-textpic-image { margin-bottom: {$styles.content.imgtext.rowSpace}px; }
	DIV.csc-textpic-equalheight DIV.csc-textpic-imagerow { margin-bottom: {$styles.content.imgtext.rowSpace}px; display: block; }
	DIV.csc-textpic DIV.csc-textpic-imagerow { clear: both; }

	/* No margins around the whole image-block */
	DIV.csc-textpic DIV.csc-textpic-imagewrap .csc-textpic-firstcol { margin-left: 0px !important; }
	DIV.csc-textpic DIV.csc-textpic-imagewrap .csc-textpic-lastcol { margin-right: 0px !important; }

	/* Add margin from image-block to text (in case of "Text w/ images") */
	DIV.csc-textpic-intext-left DIV.csc-textpic-imagewrap,
	DIV.csc-textpic-intext-left-nowrap DIV.csc-textpic-imagewrap {
		margin-right: {$styles.content.imgtext.textMargin}px !important;
	}
	DIV.csc-textpic-intext-right DIV.csc-textpic-imagewrap,
	DIV.csc-textpic-intext-right-nowrap DIV.csc-textpic-imagewrap {
		margin-left: {$styles.content.imgtext.textMargin}px !important;
	}

	/* Positioning of images: */

	/* Above */
	DIV.csc-textpic-above DIV.csc-textpic-text { clear: both; }

	/* Center (above or below) */
	DIV.csc-textpic-center { text-align: center; /* IE-hack */ }
	DIV.csc-textpic-center DIV.csc-textpic-imagewrap { margin: 0 auto; }
	DIV.csc-textpic-center DIV.csc-textpic-imagewrap .csc-textpic-image { text-align: left; /* Remove IE-hack */ }
	DIV.csc-textpic-center DIV.csc-textpic-text { text-align: left; /* Remove IE-hack */ }

	/* Right (above or below) */
	DIV.csc-textpic-right DIV.csc-textpic-imagewrap { float: right; }
	DIV.csc-textpic-right DIV.csc-textpic-text { clear: right; }

	/* Left (above or below) */
	DIV.csc-textpic-left DIV.csc-textpic-imagewrap { float: left; }
	DIV.csc-textpic-left DIV.csc-textpic-text { clear: left; }

	/* Left (in text) */
	DIV.csc-textpic-intext-left DIV.csc-textpic-imagewrap { float: left; }

	/* Right (in text) */
	DIV.csc-textpic-intext-right DIV.csc-textpic-imagewrap { float: right; }

	/* Right (in text, no wrap around) */
	DIV.csc-textpic-intext-right-nowrap DIV.csc-textpic-imagewrap { float: right; clear: both; }
	/* Hide from IE5-mac. Only IE-win sees this. \*/
	* html DIV.csc-textpic-intext-right-nowrap .csc-textpic-text { height: 1%; }
	/* End hide from IE5/mac */

	/* Left (in text, no wrap around) */
	DIV.csc-textpic-intext-left-nowrap DIV.csc-textpic-imagewrap { float: left; clear: both; }
	/* Hide from IE5-mac. Only IE-win sees this. \*/
	* html DIV.csc-textpic-intext-left-nowrap .csc-textpic-text { height: 1%; }
	/* End hide from IE5/mac */
	
	DIV.csc-textpic DIV.csc-textpic-imagerow-last { margin-bottom: 0; }

	/* Browser fixes: */

	/* Fix for unordered and ordered list with image "In text, left" */
	.csc-textpic-intext-left ol, .csc-textpic-intext-left ul {padding-left: 40px; overflow: auto; height: 1%; }

	/* Addon: CType uploads settings for dl lists */
	dl.csc-uploads { float: left; width: 100%; border-top: 1px solid #ffc096; padding-top: 1em; }
	dl.csc-uploads dt { float: left; width: 20px; margin: 0 5px 0 0; }
	dl.csc-uploads dd.csc-uploads-fileName { float: left; width: 565px; }
	dl.csc-uploads dd.csc-uploads-fileSize { float: left; width: 100px; text-align: right; }
	dl.csc-uploads dd.csc-uploads-itemSeparator { clear: both; border-bottom: 1px solid #ffc096; margin: 0 0 1em 0; }
	dl.csc-uploads dd p.bodytext { margin-top: 0; }
	)
}
*/
