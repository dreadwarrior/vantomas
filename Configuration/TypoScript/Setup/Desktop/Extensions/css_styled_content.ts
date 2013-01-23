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
										file = EXT:vantomas/Resources/Public/Images/Desktop/folded-paper.png
									}
									30 = IMAGE
									30 {
										file = EXT:vantomas/Resources/Public/Images/Desktop/grunge.png
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