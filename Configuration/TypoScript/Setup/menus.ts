lib.menu {
  # Hauptmenü
  main = HMENU
  main {
    entryLevel = 0
    wrap = {$menu.main.menuWrap}
    1 = TMENU
    1 {
      noBlur = 1
      NO = 1
      NO {
        linkWrap (
          {$menu.main.menuItemWrap}

        )
      }
      ACT < .NO
      ACT {
        linkWrap (
          {$menu.main.menuItemActiveWrap}

        )
      } 
    }
  }
  # Breadcrumb-Menü
  breadcrumb = COA
  breadcrumb {
    wrap = {$menu.breadcrumb.menuWrap}
    10 = TEXT
    10 {
      if.isTrue = {$menu.breadcrumb.prepend_you_are_here}
      data = LLL:fileadmin/templates/{$site.template_path}/l10n/template.xml:menu.breadcrumb.you_are_here
      wrap = {$menu.breadcrumb.menuItemLabelWrap}
    }
    20 = HMENU
    20 {
      special = rootline
      special.range = 0 | -1
      includeNotInMenu = {$menu.breadcrumb.includeNotInMenu}

      1 = TMENU
      1 {
        noBlur = 1
        NO = 1
        NO {
          linkWrap = {$menu.breadcrumb.menuItemWrap}
        }
        CUR < .NO
        CUR {
          doNotLinkIt = 1
        }
      }
    }
  }
}

# wenn aktuelle Seite = 1 ("Homepage"), dann Verweis "Home" auf "immer aktiv" einstellen
[globalVar = TSFE:id = 136]
lib.menu.main.alwaysActivePIDlist = 160
[global]
