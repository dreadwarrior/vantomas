// Quelle: http://www.site42.de/Wie-konfiguriert-man-den-RTE-h.58.0.html

// rtehtmlarea FAQ 3.10: damit wird class="contenttable" nur gesetzt, wenn kein class-Attribut für die Tabelle angegeben wurde
//lib.parseFunc_RTE.externalBlocks.table.stdWrap.HTMLparser.tags.table.fixAttrib.class.list >
// avoid unwanted p-elements in th/td on the way to FE
//lib.parseFunc_RTE.externalBlocks.table.HTMLtableCells.default >
//lib.parseFunc_RTE.externalBlocks.table.HTMLtableCells.default.stdWrap.parseFunc =< lib.parseFunc

// -- benutzerdefinierte Tags zur parseFunc für normale Felder hinzufügen

/*
lib.parseFunc.allowTags := addToList(star)
lib.parseFunc.tags.star = < plugin.user_tagstar_pi1
lib.parseFunc.nonTypoTagStdWrap.HTMLparser.tags.star = < plugin.user_tagstar_pi1

// -- benutzerdefinierte Tags zur parseFunc für Felder mit RTE hinzufügen

lib.parseFunc_RTE.allowTags := addToList(star)
lib.parseFunc_RTE.tags.star = < plugin.user_tagstar_pi1

// erst diese Anweisung lässt benutzerdefinierte Elemente "durch"
// man könnte auch direkt hier ein TypoScript-Objekt übergeben, ohne Plugin-Call
lib.parseFunc_RTE.nonTypoTagStdWrap.HTMLparser.tags.star = < plugin.user_tagstar_pi1

// -- wenn in Überschriften auch benutzerdefinierte Tags erlaubt sein sollen, ist folgendes TS notwendig:
lib.stdheader.10.setCurrent.parseFunc =< lib.parseFunc
lib.stdheader.10.setCurrent.htmlSpecialChars = 0
*/