// Quelle: http://www.site42.de/Wie-konfiguriert-man-den-RTE-h.58.0.html

// rtehtmlarea FAQ 3.10: damit wird class="contenttable" nur gesetzt, wenn kein class-Attribut für die Tabelle angegeben wurde
lib.parseFunc_RTE.externalBlocks.table.stdWrap.HTMLparser.tags.table.fixAttrib.class.list >
// avoid unwanted p-elements in th/td on the way to FE
lib.parseFunc_RTE.externalBlocks.table.HTMLtableCells.default >
lib.parseFunc_RTE.externalBlocks.table.HTMLtableCells.default.stdWrap.parseFunc =< lib.parseFunc

// -- benutzerdefinierte Tags zur parseFunc für normale Felder hinzufügen

lib.parseFunc.allowTags := addToList(star)
lib.parseFunc.tags.star = < plugin.user_tagstar_pi1
lib.parseFunc.nonTypoTagStdWrap.HTMLparser.tags.star = < plugin.user_tagstar_pi1

// -- benutzerdefinierte Tags zur parseFunc für Felder mit RTE hinzufügen

lib.parseFunc_RTE.allowTags := addToList(star)
lib.parseFunc_RTE.tags.star = < plugin.user_tagstar_pi1

// erst diese Anweisung lässt benutzerdefinierte Elemente "durch"
// man könnte auch direkt hier ein TypoScript-Objekt übergeben, ohne Plugin-Call
lib.parseFunc_RTE.nonTypoTagStdWrap.HTMLparser.tags.star = < plugin.user_tagstar_pi1

// -- Überschriftenkonfiguration

// damit die Redakteure die Möglichkeit haben die Überschriften umbrechen zu lassen, binden
// wir dieses Standard-TypoScript-Setup ein. An dieser Stelle können ebenfalls lib.stdheader.*-Einstellungen
// vorgenommen werden, um grafische Überschriften zu generieren
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

// -- wenn in Überschriften auch benutzerdefinierte Tags erlaubt sein sollen, ist folgendes TS notwendig:
lib.stdheader.10.setCurrent.parseFunc =< lib.parseFunc
lib.stdheader.10.setCurrent.htmlSpecialChars = 0

// -- Anpassungen für Zuschneiden "Effekt" bei Bildern

tt_content.image.20 {
	1 {
		file {
			width {
				// crop-Parameter an Breitenangabe anhängen...
				append = TEXT
				append {
					value = c
					// wenn Zuschneiden-Effekt ausgewählt wurde
					if.equals.field = image_effects
					if.value = 30
				}
			}
			// height Parameter erstellen...
			height {
				// ...wird hier ausgelesen
				field = imageheight

				// ...crop-Parameter anhängen
				append = TEXT
				append {
					value = c
				}

				// das alles nur, wenn "Zuschneiden" Effekt ausgewählt wurde
				if.equals.field = image_effects
				if.value = 30
			}
		}
	}
	equalH {
		// equalH bekommt eine Bedingung: und zwar wird dieser Parameter
		// nur gesetzt, wenn das bei Effekte nicht "Zuschneiden" ausgewählt
		// wurde
		if.equals.field = image_effects
		if.value = 30
		if.negate = 1
	}
}

tt_content.uploads {
	20 {
		itemRendering {
			30.bytes.labels = " Bytes| KBytes| MBytes| GBytes"
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