# --- Domainspezifische Einstellungen
# site.domain.* stellt die Domain ein
# hier kann man bei Sprachwechsel durch Domainwechsel auch andere Sprachen berücksichtigen

# cat=site/domain/default; type=string; label=Site Domain: Standard-Domain
site.domain.default = @@@DOMAIN_MOBILE@@@

# --- Einstellungen für Google Services

# cat=site/google/webmastertools; type=string; label=Site Google Webmastertools: Code für die Aktivierung der Webmastertools (verify-v1-Wert)
site.google.webmastertools = cGSfAr_3At6tMTpMWWH-PXSoIdGEBdgIAzR1hXmapFs
# cat=site/google/apikey; type=string; label=Site Google API: Code für verschiedene Google API Services
site.google.apikey = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
# cat=site/google/analytics; type=string; label=Site Google Analytics: ID für Google Analytics (UA-[0-9]{6,}-[0-9]{1}
site.google.analyticsid = UA-XXXXXXX-X
# cat=site/google/maps; type=string; label=Site Google Maps: geografische Breite (LAT)
site.google.maps.lat = 0.0
# cat=site/google/maps; type=string; label=Site Google Maps: geografische Länge (LNG)
site.google.maps.lng = 0.0

# --- andere Einstellungen

# cat=site/cleanup/cache; type=boolean; label=Site aufräumen: Cache de-/aktivieren
site.cache.disable = 1
# cat=site/cleanup/cache; tytpe=boolean; label=Site aufräumen: Cache-Header de-/aktivieren
site.cache.sendHeaders = 1
# cat=site/cleanup/prefixcomment; type=boolean; label=Site aufräumen: Präfixkommentare de-/aktivieren
site.prefixComment.disable = 1
# cat=site/cleanup/defaultjs; type=boolean; label=Site aufräumen: Standard-JS deaktivieren (darf nicht gesetzt werden, wenn z.B. GMENU mit RO verwendet wird!)
// kann auch external sein
site.defaultJS.disabled = 1
# cat=site/cleanup/realurl; type=boolean; label=Site aufräumen: RealURL (SuMa-freundliche URls) aktivieren
site.realURL.enable = 1