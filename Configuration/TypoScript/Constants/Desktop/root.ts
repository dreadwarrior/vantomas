# --- Template Einstellungen

# cat=site/template_path; type=string; label=Site: Ordner-Name mit den Template
site.template_path = van-tomas.de

# --- Domainspezifische Einstellungen
# site.domain.* stellt die Domain ein
# hier kann man bei Sprachwechsel durch Domainwechsel auch andere Sprachen berücksichtigen

# cat=site/domain/default; type=string; label=Site Domain: Standard-Domain
site.domain.default = www.van-tomas.de
# cat=site/domain/it; type=string; label=Site Domain: Domain für italienische Sprachversion
site.domain.it = www.van-tomas.de
# cat=site/domain/en; type=string; label=Site Domain: Domain für englische Sprachversion
site.domain.en = www.van-tomas.de

# --- Einstellungen für Google Services

# cat=site/google/webmastertools; type=string; label=Site Google Webmastertools: Code für die Aktivierung der Webmastertools (verify-v1-Wert)
site.google.webmastertools = cGSfAr_3At6tMTpMWWH-PXSoIdGEBdgIAzR1hXmapFs
# cat=site/google/apikey; type=string; label=Site Google API: Code für verschiedene Google API Services
site.google.apikey = ABQIAAAA8IGreYBro7AbEM6u2Qen8BQ9UEUlt97xoEbuPf6h5Rz_8zp21hTXWFUNVJDmAkrCdaqdXp7p4V0PPw
# cat=site/google/analytics; type=string; label=Site Google Analytics: ID für Google Analytics (UA-[0-9]{6,}-[0-9]{1}
site.google.analyticsid = UA-4668776-1
# cat=site/google/maps; type=string; label=Site Google Maps: geografische Breite (LAT)
site.google.maps.lat = 46.612009
# cat=site/google/maps; type=string; label=Site Google Maps: geografische Länge (LNG)
site.google.maps.lng = 11.162753

# --- andere Einstellungen

# cat=site/cleanup/cache; type=boolean; label=Site aufräumen: Cache de-/aktivieren
site.cache.disable = 0
# cat=site/cleanup/cache; tytpe=boolean; label=Site aufräumen: Cache-Header de-/aktivieren
site.cache.sendHeaders = 1
# cat=site/cleanup/prefixcomment; type=boolean; label=Site aufräumen: Präfixkommentare de-/aktivieren
site.prefixComment.disable = 1
# cat=site/cleanup/defaultjs; type=boolean; label=Site aufräumen: Standard-JS deaktivieren (darf nicht gesetzt werden, wenn z.B. GMENU mit RO verwendet wird!)
site.defaultJS.disabled = external
# cat=site/cleanup/realurl; type=boolean; label=Site aufräumen: RealURL (SuMa-freundliche URls) aktivieren
site.realURL.enable = 1
