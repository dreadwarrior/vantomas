# title Tag adjustments for the search results
page {
  meta {
    robots = noindex,nofollow
  }

  headerData.10 {
    postCObject = TEMPLATE
    postCObject {
      template = TEXT
      template {
        value = for keyword ###KEYWORD###
        noTrimWrap = | ||
      }
      marks {
        KEYWORD = TEXT
        KEYWORD {
          data = GP:tx_vgetagcloud_pi2|keyword
          removeBadHTML = 1
        }
      }
    }
  }
}
