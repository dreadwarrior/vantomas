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