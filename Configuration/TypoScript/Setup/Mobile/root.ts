config {
  admPanel = 0

  linkVars = L
  uniqueLinkVars = 1

  doctype = html_5

  removeDefaultJS = 1

  # alle E-Mailadressen werden als Unicode-HTML-Entities umgeschrieben
  #spamProtectEmailAddresses = ascii
  # per Default steht das hier auf (at) - Viele Kunden wünschen jedoch, dass das @ zu sehen
  # ist, also stellen wir das so ein
  spamProtectEmailAddresses_atSubst = @
  #spamProtectEmailAddresses_lastDotSubst = (dot)
  # Notiz: nur zu Testzwecken, in Produktivumgebung zu entfernen/auskommentieren
  no_cache = {$site.cache.disable}
  disablePrefixComment = {$site.prefixComment.disable}

  headerComment (
  (c) 2011 Thomas Juhnke
  )

  # für SEO: fügt n (20) Zeichen den temporären GIFBUILDER-Dateinamen hinzu
  meaningfulTempFilePrefix = 20

  notification_email_charset = UTF-8
  # Seitentitel ausblenden, kommt aus Seiteneigenschaften->Untertitel
  noPageTitle = 2

  language = en
  //htmlTag_langKey = en-US
  locale_all = en_US.UTF8
  sys_language_uid = 0
  sys_language_mode = content_fallback
  sys_language_overlay = hideNonTranslated

  metaCharset = utf-8
  renderCharset = utf-8

  # realURL-Konfiguration
  simulateStaticDocuments = 0
  tx_realurl_enable = {$site.realURL.enable}
  prefixLocalAnchors = all

  sendCacheHeaders = {$site.cache.sendHeaders}

  baseURL = http://{$site.domain.default}/

  // @see http://dmitry-dulepov.com/article/creating-a-mobile-version-of-a-web-site.html
  absRefPrefix = /
  inlineStylesToTempFile = 0
}

page = PAGE
page {
  typeNum = 0

  meta {
    description = TEXT
    description.data = field:description
    keywords = TEXT
    keywords.data = field:keywords
    # Google Webmaster Tools Verification Code
    google-site-verification = {$site.google.webmastertools}
    robots = noindex,nofollow
    viewport = width=device-width, initial-scale=1
  }

  headerData {
    # title-Attribut kommt aus Untertitel // Titel-Feld der Seite
    10 = TEXT
    10 {
      field = subtitle // title
      htmlSpecialChars = 1
      noTrimWrap = |<title>|</title>|
    }

    # Favicon
    19 = TEXT
    19.value = <link rel="apple-touch-icon" type="image/png" href="http://mobile.van-tomas.de/fileadmin/templates/{$site.template_path}/img/favicon.png" />
  }

  includeCSS {
    style = fileadmin/templates/{$site.template_path}/css/style.css
    jquery_mobile = http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css
    jquery_mobile.external = 1
  }
  includeJS {
    jquery = http://code.jquery.com/jquery-1.7.1.min.js
    jquery.external = 1
    jquery_mobile = http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js
    jquery_mobile.external = 1
    tx_comments = typo3conf/ext/comments/resources/template/pi1.js
  }

  bodyTag = <body>

  50 = USER
  50 {
    userFunc = tx_templavoila_pi1->main_page
    disableExplosivePreview = 1
  }
}

// -- remove default styles of some plugins
plugin.tx_cssstyledcontent._CSS_DEFAULT_STYLE >
plugin.tx_felogin_pi1._CSS_DEFAULT_STYLE >
plugin.tx_indexedsearch._CSS_DEFAULT_STYLE >
plugin.tx_thmailformplus_pi1._CSS_DEFAULT_STYLE >
// -- no need for the socialbookmark bar...
plugin.tx_spsocialbookmarks_pi1 >

[globalString = IENV:HTTP_HOST = mobile.van-tomas.de]
page {
  50.childTemplate = ajax
}
[global]
