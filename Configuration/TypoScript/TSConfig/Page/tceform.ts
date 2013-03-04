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