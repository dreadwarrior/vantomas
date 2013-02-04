TCEMAIN {
  translateToMessage = Bitte in "%s" übersetzen:
  table {
    pages {
      disablePrependAtCopy = 1
      disableHideAtCopy = 1
    }
    tt_content {
      disableHideAtCopy = 1
      disablePrependAtCopy = 1
    }
  }
  permissions {
    # Die Gruppe "Basis" wird beim Erstellen einer neuen
    # Seite als Standard-Gruppe eingestellt
    #groupid = 5
    # Gruppen-Rechte werden um "löschen" erweitert
    #group = 31
  }
}

mod {
  SHARED {
    defaultLanguageFlag = gb
    defaultLanguageLabel = english
  }
  web_layout {
    defLangBinding = 1
  }
  web_list {
    alternateBgColors = 1
    #listOnlyInSingleTableView = 1
  }
}

TCEFORM {
  tt_content {
      # Breite des RTE in Fullscreen-Ansicht
    bodytext.RTEfullScreenWidth= 80%
    section_frame {
      # 10 (Einrücken) drinlassen
      #removeItems = 1,5,6,11,12,20,21
    }
    header_layout {
      altLabels {
        #1 = Groesse 1
        #2 = Groesse 2
        #3 = Groesse 3
        #4 = grafische Überschrift
        #5 = normale Überschrift
      }
      #removeItems = 0,1,2,3
      addItems {
        #6 = grafische Boxen-Überschrift
      }
    }
    image_effects {
      addItems {
        30 = Zuschneiden
      }
      # alle Standard-Effekte entfernen
      removeItems = 1,2,3,10,11,20,23,25,26
    }
  }
}

#*** RTE Classe des Interface (Ausrichtung)
RTE.classes {
  align-left {
    name = LLL:EXT:rtehtmlarea/htmlarea/locallang_tooltips.xml:justifyleft
    value = text-align: left;
  }
  align-center {
    name = LLL:EXT:rtehtmlarea/htmlarea/locallang_tooltips.xml:justifycenter
    value = text-align: center;
  }
  align-right {
    name = LLL:EXT:rtehtmlarea/htmlarea/locallang_tooltips.xml:justifyright
    value = text-align: right;
  }
}
 
#
# *** Entfernt das Bild vor den Links
RTE.classesAnchor {
  internalLink {
    class = internal-link
    type = page
    image >
    titleText >
  }
  externalLink {
    class = external-link
    type = url
    image >
    titleText >
  }
  externalLinkInNewWindow {
    class = external-link-new-window
    type = url
    image >
    titleText >
  }
  internalLinkInNewWindow {
    class = internal-link-new-window
    type = page
    image >
    titleText >
  }
  download {
    class = download
    type = file
    image >
    titleText >
  }
  pdfDownload {
    class = download-pdf
    type = file
    image >
  }
  mail {
    class = mail
    type = mail
    image >
    titleText >
  }
}
 
 
  # RTE configuration
RTE.default {
  # content css file
  #contentCSS = fileadmin/templates/domain.tld/css/style-rte.css
       
  ## Markup options
  enableWordClean = 1
  removeTrailingBR = 1
  removeComments = 1
  removeTags = center, sdfield
  removeTagsAndContents = style,script
 
  # visible/hidden buttons
  showButtons = textstyle, textstylelabel, blockstyle, blockstylelabel, bold, italic, underline, left, center, right, orderedlist, unorderedlist, insertcharacter, line, link,removeformat, table, toggleborders, tableproperties, rowproperties, rowinsertabove, rowinsertunder, rowdelete, rowsplit, columninsertbefore, columninsertafter, columndelete, columnsplit, cellproperties, cellinsertbefore, cellinsertafter, celldelete, cellsplit, cellmerge, findreplace, insertcharacter, undo, redo, showhelp, chMode, about
  hideButtons = fontstyle, formatblock, fontsize, strikethrough,lefttoright, righttoleft, textcolor, bgcolor, textindicator, emoticon, spellcheck, inserttag, outdent,  image, indent, justifyfull, subscript, superscript, acronym, copy, cut, paste, user
 
  # groups RTE button icons
  keepButtonGroupTogether = 1
 
  # disable/enable statusbar
  showStatusBar =  1
 
  # Add styles Left, center and right alignment of text in paragraphs and cells.
  inlineStyle.text-alignment (
    p.align-left, h1.align-left, h2.align-left, h3.align-left, h4.align-left, h5.align-left, h6.align-left, td.align-left { text-align: left; }
    p.align-center, h1.align-center, h2.align-center, h3.align-center, h4.align-center, h5.align-center, h6.align-center, td.align-center { text-align: center; }
    p.align-right, h1.align-right, h2.align-right, h3.align-right, h4.align-right, h5.align-right, h6.align-right, td.align-right { text-align: right; }
  )
 
  # Use stylesheet file rather than the above mainStyleOverride and inlineStyle properties to style the contents (htmlArea RTE only)
  ignoreMainStyleOverride = 1
       
  proc {
    # allowed / disallowed tags
    allowTags = table, tbody, tr, th, td, h1, h2, h3, h4, h5, h6, div, p, br, span, ul, ol, li, re, blockquote, strong, em, b, i, u, sub, sup, strike, a, img, nobr, hr, tt, q, cite, abbr, acronym, center, pre, code
    denyTags = font

    # br wird nicht zu p konvertiert
    dontConvBRtoParagraph = 1

    # allowed tags outside of p, div
    allowTagsOutside = img,hr

    # allowed attributes in p, div tags
    keepPDIVattribs = align,class,style,id

    # List all class selectors that are allowed on the way to the database
    # added "styled", "farbe1" and "farbe2" to allow formatting of tables and table cells
    allowedClasses (
      external-link, external-link-new-window, internal-link, internal-link-new-window, download, mail,
      align-left, align-center, align-right, author, styled, farbe1, farbe2
    )       

    # html parser einstellungen
    HTMLparser_rte = 1
    HTMLparser_rte {
      # tags die erlaubt/verboten sind
      allowTags < RTE.default.proc.allowTags
      denyTags < RTE.default.proc.denyTags

      # tags die untersagt sind
      removeTags = font

      # entfernt html-kommentare
      removeComments = 1

      # tags die nicht übereinstimmen werden nicht entfernt (protect / 1 / 0)
      keepNonMatchedTags = 0
    }


    # Content to database
    entryHTMLparser_db = 1
    entryHTMLparser_db {
      # tags die erlaubt/verboten sind
      allowTags < RTE.default.proc.allowTags
      denyTags < RTE.default.proc.denyTags

      # CLEAN TAGS
      noAttrib = b, i, u, strike, sub, sup, strong, em, quote, blockquote, cite, tt, br, center

      rmTagIfNoAttrib = span,div,font

      # Hinweis: dies ist in der Standardkonfiguration auskommentiert...
      # htmlSpecialChars = 1

      # align attribute werden erlaubt
      tags {
        p.fixAttrib.align.unset >
        p.allowedAttribs = class,style,align

        div.fixAttrib.align.unset >

        hr.allowedAttribs = class

        # b und i tags werden ersetzt (em / strong)
        b.remap = strong
        i.remap = em

        # img tags werden erlaubt
        img >
      }
    }
  }
 
  # Classes: Ausrichtung
  buttons.blockstyle.tags.div.allowedClasses (
    align-left, align-center, align-right
  )
 
  # Classes: Eigene Stile
  buttons.textstyle.tags.span.allowedClasses = author
  buttons.image.properties.class.allowedClasses= rte_image
 
  # Classes für Links (These classes should also be in the list of allowedClasses)
  classesAnchor = external-link, external-link-new-window, internal-link, internal-link-new-window, download, mail
  classesAnchor.default {
    page = internal-link
    url = external-link-new-window
    file = download
    mail = mail
  }
 
  buttons.blockstyle.tags.table.allowedClasses = styled
  # CSS classes for table cells
  buttons.blockstyle.tags.td.allowedClasses = farbe1, farbe2

  # zeigt alle CSS-Klassen die in formate.css vorhanden sind
  showTagFreeClasses = 1

  # Do not allow insertion of the following tags
  hideTags = font

  # Tabellen Optionen in der RTE Toolbar
  hideTableOperationsInToolbar = 0
  keepToggleBordersInToolbar = 1

  # Tabellen Editierungs-Optionen (cellspacing/ cellpadding / border)
  disableSpacingFieldsetInTableOperations = 1
  disableAlignmentFieldsetInTableOperations = 0
  disableColorFieldsetInTableOperations = 1
  disableLayoutFieldsetInTableOperations = 0
  disableBordersFieldsetInTableOperations = 1
}
 
# Use same processing as on entry to database to clean content pasted into the editor
RTE.default.enableWordClean.HTMLparser < RTE.default.proc.entryHTMLparser_db
 
# FE RTE configuration (htmlArea RTE only)
RTE.default.FE < RTE.default
RTE.default.FE.userElements >
RTE.default.FE.userLinks >

# --- RTE Konfiguration für benutzerdefinierte Tags (Custom Tags)

# button settings
#RTE.default.showButtons := addToList(user)
#RTE.default.hideButtons := removeFromList(user)

# allowed/denied tags
#RTE.default.proc.allowTags := addToList(star)
#RTE.default.proc.denyTags := removeFromList(star)

# HTMLparser_rte settings
#RTE.default.proc.HTMLparser_rte = 1
# don't mask special html characters like < or >
#RTE.default.proc.HTMLparser_rte.htmlSpecialChars = 0
# protect specific, user defined tags
#RTE.default.proc.HTMLparser_rte.tags.star.protect = 1

# entryHTMLparser_db settings
# special html characters like < or > will be stored unmasked (get masked by re-display in RTE)
#RTE.default.proc.entryHTMLparser_db.htmlSpecialChars = -1
# protect specific tag
#RTE.default.proc.entryHTMLparser_db.tags.star.protect = 1
# protect non matching tags
#RTE.default.proc.entryHTMLparser_db.keepNonMatchedTags = protect

# exitHTMLparser_db settings
#RTE.default.proc.exitHTMLparser_db = 1
# protected non matched tags during fetching from database
#RTE.default.proc.exitHTMLparser_db.keepNonMatchedTags = 1
# don't mask html characters like < or >
#RTE.default.proc.exitHTMLparser_db.htmlSpecialChars = 0

# RTE plugin "user" settings
# define group name
#RTE.default.userElements.10 = Eigene Tags
# tag configuration
#RTE.default.userElements.10.1 = Sterne
#RTE.default.userElements.10.1.description = Der ausgewählte Text wird umschlossen von <star></star>
#RTE.default.userElements.10.1.mode = wrap
#RTE.default.userElements.10.1.content = <star theme="1">|</star>

/*
tx_crawler.crawlerCfg.paramSets {
  language = &L=[|_TABLE:pages_language_overlay;_FIELD:sys_language_uid]
  #language = &tx_abc_pi1[schnipp]=[0-100]&tx_abc_pi1[schnapp]=[0-100]
  language.procInstrFilter = tx_indexedsearch_reindex, tx_cachemgm_recache
  language.baseUrl = http://typo3-dev.local/
  #mininews = &L=[|_TABLE:pages_language_overlay;_FIELD:sys_language_uid]&tx_mininews_pi1[showUid]=[_TABLE:tx_mininews_news]
  #mininews.procInstrFilter = tx_indexedsearch_reindex
  #mininews.cHash = 1
  #mininews.baseUrl = http://localhost:8888/typo3/dummy_4.0/
 
  threst = &tx_threstcountriesandhotels_pi1[country]=[1|15]&tx_threstcountriesandhotels_pi1[pointer]=[|1-10]
  threst.procInstrFilter = tx_indexedsearch_reindex
  threst.cHash = 0
  threst.baseUrl = http://typo3-dev.local/
}
*/
