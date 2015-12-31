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
        // Die Gruppe "Basis" wird beim Erstellen einer neuen
        // Seite als Standard-Gruppe eingestellt
        #groupid = 5

        // Gruppen-Rechte werden um "löschen" erweitert
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

    wizards {
        newContentElement {
            wizardItems {
                vantomas_plugins {
                    header = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.header
                    show = archive_list, archive_search, site_lastupdatedpages, disqus_latest, twitter_timeline, twitter_search, tagcloud, tagsearch, contactform, secret_santa_reveal_donee, secret_santa_access_control
                    elements {
                        archive_list {
                            iconIdentifier = vantomas-plugin-archivelist
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.archive_list.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.archive_list.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_archivelist
                            }
                        }
                        archive_search {
                            iconIdentifier = vantomas-plugin-archivesearch
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.archive_search.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.archive_search.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_archivesearch
                            }
                        }
                        site_lastupdatedpages {
                            iconIdentifier = vantomas-plugin-sitelastupdatedpages
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.site_lastupdatedpages.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.site_lastupdatedpages.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_sitelastupdatedpages
                            }
                        }
                        disqus_latest {
                            iconIdentifier = vantomas-plugin-disquslatest
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.disqus_latest.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.disqus_latest.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_disquslatest
                            }
                        }
                        twitter_timeline {
                            iconIdentifier = vantomas-plugin-twittertimeline
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.twitter_timeline.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.twitter_timeline.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_twittertimeline
                            }
                        }
                        twitter_search {
                            iconIdentifier = vantomas-plugin-twittersearch
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.twitter_search.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.twitter_search.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_twittersearch
                            }
                        }
                        tagcloud {
                            iconIdentifier =
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.tagcloud.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.tagcloud.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_tagcloud
                            }
                        }
                        tagsearch {
                            iconIdentifier = vantomas-plugin-tagcloud
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.tagsearch.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.tagsearch.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_tagsearch
                            }
                        }
                        contactform {
                            iconIdentifier = vantomas-plugin-contactform
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.contact_form.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.contact_form.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_contactform
                            }
                        }
                        secret_santa_reveal_donee {
                            iconIdentifier = vantomas-plugin-secretsanta
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.secret_santa_reveal_donee.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.secret_santa_reveal_donee.description
                            tt_content_defValues {
                                CType = list
                                list_type = vantomas_secretsanta
                            }
                        }
                        secret_santa_access_control {
                            iconIdentifier = vantomas-plugin-secretsanta
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.secret_santa_access_control.title
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_plugins.elements.secret_santa_access_control.description
                            tt_content_defValues {
                                CType = List
                                list_type = vantomas_secretsantaaccesscontrol
                            }
                        }
                    }
                }

                vantomas_contentelements {
                    header = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:necoelwi.group.vantomas_contentelements.header

                    show = vantomas_orbiter, vantomas_codesnippet

                    elements {
                        vantomas_orbiter {
                            iconIdentifier = vantomas-contentelement-orbiter
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:content_element.orbiter
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:content_element.orbiter.description

                            tt_content_defValues {
                                CType = vantomas_orbiter
                            }
                        }
                        vantomas_codesnippet {
                            iconIdentifier = vantomas-contentelement-codesnippet
                            title = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:content_element.code_snippet
                            description = LLL:EXT:vantomas/Resources/Private/Language/locallang_db.xlf:content_element.code_snippet.description

                            tt_content_defValues {
                                CType = vantomas_codesnippet
                            }
                        }
                    }
                }
            }
        }
    }
}

TCEFORM {
    tt_content {
        // Breite des RTE in Fullscreen-Ansicht
        bodytext.RTEfullScreenWidth= 80%
        section_frame {
            // 10 (Einrücken) drinlassen
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

            // alle Standard-Effekte entfernen
            removeItems = 1,2,3,10,11,20,23,25,26
        }
    }
}

// RTE Classe des Interface (Ausrichtung)
RTE {
    classes {
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


    // Entfernt das Bild vor den Links
    classesAnchor {
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

    // RTE configuration
    default {
        // content css file
        #contentCSS = fileadmin/templates/domain.tld/css/style-rte.css

        // Markup options
        enableWordClean = 1
        removeTrailingBR = 1
        removeComments = 1
        removeTags = center, sdfield
        removeTagsAndContents = style,script

        // visible/hidden buttons
        showButtons = textstyle, textstylelabel, blockstyle, blockstylelabel, bold, italic, underline, left, center, right, orderedlist, unorderedlist, insertcharacter, line, link,removeformat, table, toggleborders, tableproperties, rowproperties, rowinsertabove, rowinsertunder, rowdelete, rowsplit, columninsertbefore, columninsertafter, columndelete, columnsplit, cellproperties, cellinsertbefore, cellinsertafter, celldelete, cellsplit, cellmerge, findreplace, insertcharacter, undo, redo, showhelp, chMode, about
        hideButtons = fontstyle, formatblock, fontsize, strikethrough,lefttoright, righttoleft, textcolor, bgcolor, textindicator, emoticon, spellcheck, inserttag, outdent,    image, indent, justifyfull, subscript, superscript, acronym, copy, cut, paste, user

        // groups RTE button icons
        keepButtonGroupTogether = 1

        // disable/enable statusbar
        showStatusBar =    1

        // Classes: Ausrichtung
        buttons {
            blockstyle {
                showTagFreeClasses = 1

                tags {
                    div.allowedClasses (
                        align-left, align-center, align-right
                    )
                    table.allowedClasses = styled
                    // CSS classes for table cells
                    td.allowedClasses = farbe1, farbe2
                }
            }
            textstyle {
                showTagFreeClasses = 1

                tags {
                    span.allowedClasses = author
                }
            }
            image {
                properties.class.allowedClasses= rte_image
            }
            // Classes für Links (These classes should also be in the list of allowedClasses)
            link {
                properties.class.allowedClasses = external-link, external-link-new-window, internal-link, internal-link-new-window, download, mail

                page.properties.class.default = internal-link
                url.properties.class.default = external-link-new-window
                file.properties.class.default = download
                mail.properties.class.default = mail
            }
        }

        proc {
            // allowed / disallowed tags
            allowTags = table, thead, tbody, tr, th, td, h1, h2, h3, h4, h5, h6, div, p, br, span, ul, ol, li, re, blockquote, strong, em, b, i, u, sub, sup, strike, a, img, nobr, hr, tt, q, cite, abbr, acronym, center
            denyTags = font

            // br wird nicht zu p konvertiert
            dontConvBRtoParagraph = 1

            // allowed tags outside of p, div
            allowTagsOutside = img,hr

            // allowed attributes in p, div tags
            keepPDIVattribs = align,class,style,id

            // List all class selectors that are allowed on the way to the database
            // added "styled", "farbe1" and "farbe2" to allow formatting of tables and table cells
            allowedClasses (
                external-link, external-link-new-window, internal-link, internal-link-new-window, download, mail,
                align-left, align-center, align-right, author, styled, farbe1, farbe2
            )

            // html parser einstellungen
            HTMLparser_rte = 1
            HTMLparser_rte {
                // tags die erlaubt/verboten sind
                allowTags < RTE.default.proc.allowTags
                denyTags < RTE.default.proc.denyTags

                // tags die untersagt sind
                removeTags = font

                // entfernt html-kommentare
                removeComments = 1

                // tags die nicht übereinstimmen werden nicht entfernt (protect / 1 / 0)
                keepNonMatchedTags = 0
            }


            // Content to database
            entryHTMLparser_db = 1
            entryHTMLparser_db {
                // tags die erlaubt/verboten sind
                allowTags < RTE.default.proc.allowTags
                denyTags < RTE.default.proc.denyTags

                // CLEAN TAGS
                noAttrib = b, i, u, strike, sub, sup, strong, em, quote, blockquote, cite, tt, br, center

                rmTagIfNoAttrib = span,div,font

                // Hinweis: dies ist in der Standardkonfiguration auskommentiert...
                # htmlSpecialChars = 1

                // align attribute werden erlaubt
                tags {
                    p.fixAttrib.align.unset >
                    p.allowedAttribs = class,style,align

                    div.fixAttrib.align.unset >

                    hr.allowedAttribs = class

                    // b und i tags werden ersetzt (em / strong)
                    b.remap = strong
                    i.remap = em

                    // img tags werden erlaubt
                    img >
                }
            }
        }

        // Do not allow insertion of the following tags
        hideTags = font

        // Tabellen Optionen in der RTE Toolbar
        hideTableOperationsInToolbar = 0
        keepToggleBordersInToolbar = 1

        // Tabellen Editierungs-Optionen (cellspacing/ cellpadding / border)
        disableSpacingFieldsetInTableOperations = 1
        disableAlignmentFieldsetInTableOperations = 0
        disableColorFieldsetInTableOperations = 1
        disableLayoutFieldsetInTableOperations = 0
        disableBordersFieldsetInTableOperations = 1
    }
}

// Use same processing as on entry to database to clean content pasted into the editor
RTE.default.enableWordClean.HTMLparser < RTE.default.proc.entryHTMLparser_db

// FE RTE configuration (htmlArea RTE only)
RTE.default.FE < RTE.default
RTE.default.FE.userElements >
RTE.default.FE.userLinks >

// --- RTE Konfiguration für benutzerdefinierte Tags (Custom Tags)

// button settings
#RTE.default.showButtons := addToList(user)
#RTE.default.hideButtons := removeFromList(user)

// allowed/denied tags
#RTE.default.proc.allowTags := addToList(star)
#RTE.default.proc.denyTags := removeFromList(star)

// HTMLparser_rte settings
#RTE.default.proc.HTMLparser_rte = 1
// don't mask special html characters like < or >
#RTE.default.proc.HTMLparser_rte.htmlSpecialChars = 0
// protect specific, user defined tags
#RTE.default.proc.HTMLparser_rte.tags.star.protect = 1

// entryHTMLparser_db settings
// special html characters like < or > will be stored unmasked (get masked by re-display in RTE)
#RTE.default.proc.entryHTMLparser_db.htmlSpecialChars = -1
// protect specific tag
#RTE.default.proc.entryHTMLparser_db.tags.star.protect = 1
// protect non matching tags
#RTE.default.proc.entryHTMLparser_db.keepNonMatchedTags = protect

// exitHTMLparser_db settings
#RTE.default.proc.exitHTMLparser_db = 1
// protected non matched tags during fetching from database
#RTE.default.proc.exitHTMLparser_db.keepNonMatchedTags = 1
// don't mask html characters like < or >
#RTE.default.proc.exitHTMLparser_db.htmlSpecialChars = 0

// RTE plugin "user" settings
// define group name
#RTE.default.userElements.10 = Eigene Tags
// tag configuration
#RTE.default.userElements.10.1 = Sterne
#RTE.default.userElements.10.1.description = Der ausgewählte Text wird umschlossen von <star></star>
#RTE.default.userElements.10.1.mode = wrap
#RTE.default.userElements.10.1.content = <star theme="1">|</star>
