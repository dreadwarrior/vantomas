# hier ist Platz, um statische Inhaltselemente zu definieren
# dies ist manchmal erforderlich, wenn schnell eine spezielle Funktionalität
# gewünscht wird, aber keine Zeit für flexible Inhaltselemente oder ein Plugin ist
lib.static {
  page_abstract = COA
  page_abstract {
    10 = TEXT
    10 {
      cObject = COA
      cObject {
        # e.g. 24th march 2010
        10 = TEXT
        10 {
          data = page:lastUpdated
          #date = jS F Y
          date = F jS, Y
        }
        15 = TEXT
        15.value = •
        15.noTrimWrap = | | |
        20 = TEXT
        20.data = page:keywords
        25 = TEXT
        25.value = •
        25.noTrimWrap = | | |
        # link to comments part
        30 = TEXT
        30.value = comments
        30.typolink {
          parameter.data = page:uid
          section = comment-list
        }
        40 = TEXT
        40.value (
          <div class="twitter-share-button-container"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="dreadwarrior" data-related="typo3:TYPO3 Association">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
        )
      }
      wrap = <div class="post-item-meta">|</div>
    }
    20 = COA
    20 {
      /*
      10 < tt_content.image.20
      10 {
        1 {
          altText {
            data = page:subtitle // page:title
          }
          titleText {
            data = page:subtitle // page:title
          }
        }
        imgList.field >
        imgList.data = page:media
        imgPath = uploads/media/
        border >
        border = 1
      }
      */
      10 = IMAGE
      10 {
        file = GIFBUILDER
        file {
          XY = [10.w],[10.h]
          10 = IMAGE
          10 {
            file.import = uploads/media/
            file.import.data = page:media
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
        data = page:abstract
        parseFunc = < lib.parseFunc_RTE
      }
      wrap = <div class="abstract">|</div>
    }
  }

  # -- copyright in footer bar
  copyright = COA
  copyright {
    10 = TEXT
    10 {
      value = © 2007-{date:Y} van-tomas.de created by Thomas Juhnke
      insertData = 1
    }
    20 = TEXT
    20.value = |
    20.noTrimWrap = | | |
    30 = TEXT
    30.value = <a href="#content-container">Back to top</a>
    40 < .20
    50 = TEXT
    50 {
      value = RSS Feed
      typolink {
        parameter.data = leveluid:0
        additionalParams = &type=103
        ATagParams = class="rss-feed"
      }
    }
    stdWrap.wrap = <p class="bodytext">|</p>
  }

  # -- latest comment retrieval
  latest_comments = CONTENT
  latest_comments {
    select {
      pidInList = 143
      recursive = 1
      orderBy = crdate DESC
      max = 5
      where = approved = 1 AND deleted = 0
    }
    table = tx_comments_comments
    renderObj = TEXT
    renderObj {
      cObject = TEMPLATE
      cObject {
        template = TEXT
        #template.value = <!-- ###COMMENT_LINK### -->###COMMENT_EXCERPT###<!-- ###COMMENT_LINK### --> by ###AUTHOR_FIRSTNAME### ###AUTHOR_LASTNAME### at ###DATE###
        template.value = <!-- ###COMMENT_LINK### -->###COMMENT_EXCERPT###<!-- ###COMMENT_LINK### --> by ###AUTHOR_FIRSTNAME### ###AUTHOR_LASTNAME### at <!-- ###PAGE_LINK### -->###PAGE_TITLE###<!-- ###PAGE_LINK### -->
        marks {
          COMMENT_EXCERPT = TEXT
          COMMENT_EXCERPT {
            field = content
            crop = 140|...|1
          }
          AUTHOR_FIRSTNAME = TEXT
          AUTHOR_FIRSTNAME.field = firstname
          AUTHOR_LASTNAME = TEXT
          AUTHOR_LASTNAME.field = lastname
          DATE = TEXT
          DATE {
            field = crdate
            strftime < plugin.tx_comments_pi1.advanced.dateFormat
          }
          PAGE_TITLE = RECORDS
          PAGE_TITLE {
            source.field = pid
            tables = pages
            conf.pages = TEXT
            conf.pages {
              field = subtitle // title
            }
          }
        }
        wraps {
          COMMENT_LINK = TEXT
          COMMENT_LINK {
            value = |
            typolink {
              parameter.field = pid
              section {
                field = uid
                wrap = comment-|
              }
            }
          }
          PAGE_LINK = TEXT
          PAGE_LINK {
            value = |
            typolink.parameter.field = pid
          }
        }
      }
      wrap = <li>|</li>
    }
    stdWrap.wrap = <ul class="striped">|</ul>
  }

  # -- most popular pages

  # NOTE: this list gets updated after *next* page hit,
  # because this TS Setup is built before the session key
  # gets updated from within the cs_counter_plus extension
  most_popular_pages = CONTENT
  most_popular_pages {
    select {
      # all sub pages of branch "Blog"
      pidInList = 143
      # orderBy according to visits field from cs_counter_plus table
      orderBy = tx_cscounterplus_info.visits DESC
      max = 5
      # join with cs_counter_plus table
      join = tx_cscounterplus_info ON pages.uid = tx_cscounterplus_info.cid
    }
    table = pages
    renderObj = TEXT
    renderObj {
      cObject = TEMPLATE
      cObject {
        template = TEXT
        template.value = <!-- ###PAGE_LINK### -->###PAGE_TITLE###<!-- ###PAGE_LINK### -->
        marks {
          PAGE_TITLE = TEXT
          PAGE_TITLE.field = subtitle // title
        }
        wraps {
          PAGE_LINK = TEXT
          PAGE_LINK {
            value = |
            typolink.parameter.field = uid
          }
        }
      }
      wrap = <li>|</li>
    }
    stdWrap.wrap = <ul class="striped">|</ul>
  }

  # -- 3rd, 4th and 5th last updated page for start page 3col display
  last_updated_page {
    number3 = CONTENT
    number3 {
      select {
        # Blog sub tree branch
        pidInList = 143
        orderBy = lastUpdated DESC
        max = 1
        begin = 2
      }
      table = pages
      renderObj = COA
      renderObj {
        10 = TEXT
        10 {
          field = subtitle // title
          typolink.parameter.field = uid
          wrap = <h2 class="csc-firstHeader">|</h2>
        }
        20 = TEXT
        20 {
          field = abstract
          parseFunc = < lib.parseFunc_RTE
          wrap = <div class="content">|</div>
        }
        30 = TEXT
        30 {
          value = read more
          typolink {
            parameter.field = uid
            ATagParams = class="round"
          }
          wrap (
            <ul class="post-item-actions">
              <li>|</li>
            </ul>
          )
        }
      }
      stdWrap.wrap = <div class="post-item no-border">|</div>
    }
    number4 < .number3
    number4.select.begin = 3
    number5 < .number3
    number5.select.begin = 4
  }

  # -- sidebar archive list
  sidebar_archive = CONTENT
  sidebar_archive {
    select {
      pidInList = 143
      orderBy = lastUpdated DESC
      groupBy = ym
      where = nav_hide = 0
      selectFields = *, DATE_FORMAT(FROM_UNIXTIME(lastUpdated), '%Y-%m') ym
    }
    table = pages
    renderObj = TEXT
    renderObj {
      #field = subtitle // title
      field = lastUpdated // crdate
      strftime = %B %Y

      typolink {
        parameter = 158
        additionalParams {
          cObject = TEMPLATE
          cObject {
            template = TEXT
            template.value = &archive[month]=###MONTH###&archive[year]=###YEAR###
            marks {
              MONTH = TEXT
              MONTH {
                field = lastUpdated // crdate
                strftime = %m
              }
              YEAR = TEXT
              YEAR {
                field = lastUpdated // crdate
                strftime = %Y
              }
            }
          }
        }
      }
      wrap = <li>|</li>
    }
    stdWrap.wrap = <ul>|</ul>
  }

  # -- archive month/year query list
  query_archive = COA_INT
  query_archive {
    10 = CONTENT
    10 {
      select {
        pidInList = 143
        orderBy = lastUpdated DESC
        where = nav_hide = 0
        #selectFields = ()/*
        andWhere {
          cObject = TEMPLATE
          cObject {
            template = TEXT
            template.value = lastUpdated BETWEEN UNIX_TIMESTAMP('###YEAR###-###MONTH###-01 00:00:01') AND UNIX_TIMESTAMP(CONCAT(LAST_DAY('###YEAR###-###MONTH###-01'), ' 23:59:59'))
            marks {
              YEAR = TEXT
              YEAR {
                data = GP:archive|year
                intval = 1
                removeBadHTML = 1
                stripHtml = 1
              }
              MONTH = TEXT
              MONTH {
                data = GP:archive|month
                #intval = 1
                removeBadHTML = 1
                stripHtml = 1
              }
            }
          }
        }
      }
      table = pages
      renderObj = COA_INT
      renderObj {
        10 = TEXT
        10 {
          field = subtitle // title
          typolink.parameter.field = uid
          wrap = <h2>|</h2>
        }
        #20 = TEXT
        #20.value = <br />
        30 = TEXT
        30 {
          field = lastUpdated
          #date = jS F Y
          date = F jS, Y
          wrap = <div class="post-item-meta">|</div>
        }
        40 = TEXT
        40 {
          field = abstract
          cropHTML = 255|...|1
          parseFunc = < lib.parseFunc_RTE
        }
        50 = TEXT
        50 {
          value = read more
          typolink {
            parameter.field = uid
            ATagParams = class="round"
          }
          wrap (
          <ul class="post-item-actions">
          <li>|</li>
          </ul>
          )
        }
        
        /*
              wrap (
                <div class="post-item post-item-tile">|</div>
        
              )
              */
        wrap (
        <div class="post-item">|</div>
        
        )
      }
      #stdWrap.wrap = <ul>|</ul>
    }
  }
}
