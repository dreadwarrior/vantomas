plugin.tx_vgetagcloud_pi1 {
  #baseWrap.wrap = <div class="box-shaded">|</div>
  tagWrap {
    typolink {
      ATagParams {
        cObject {
          dataWrap = id="tag{field:tag_id}" title="|" rel="nofollow tag"
        }
      }
    }
  }

  _CSS_DEFAULT_STYLE (
    .tx-vgetagcloud-pi1 {
      line-height: 200%;
    }
    .tx-vgetagcloud-pi1 ul {
      margin: 0px;
      padding: 0px;
      list-style: none;
      float: left;
    }
    .tx-vgetagcloud-pi1 li {
      display: inline;
      float: left;
    }
    .tx-vgetagcloud-pi1 li a {
      padding: 4px;
      text-decoration: none;
    }
  )
}

plugin.tx_vgetagcloud_pi2 {
  message.wrap = <p class="bodytext">|</p>

  #results < lib.static.archive_query

  results = HMENU
  results {
    special = list
    special.value.field = tag_pages

    1 = TMENU
    1 {
      NO.allWrap = <li>|</li>
      #NO {
        #stdWrap.override.cObject =< lib.static.query_archive.renderObj
      #}
    }
    wrap = <ul>|</ul>
  }
}
