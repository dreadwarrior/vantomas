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
}

# wenn aktuelle Seite = 1 ("Homepage"), dann Verweis "Home" auf "immer aktiv" einstellen
[globalVar = TSFE:id = 136]
lib.menu.main.alwaysActivePIDlist = 160
[global]
