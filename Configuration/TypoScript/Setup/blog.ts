<INCLUDE_TYPOSCRIPT: source="FILE:EXT:cs_counter_plus/pi1/static/setup.txt">

# no display of counter start date
plugin.tx_cscounterplus_pi1.showSince = 0
# no leading zeros
plugin.tx_cscounterplus_pi1.minDigits = 1
# HTML comment around counter plugin
plugin.tx_cscounterplus_pi1.wrap = <!-- page visits: | -->

# integrate counter plugin into page rendering except hidden pages
# (eg. tag/archive search result) and not if logged in backend
[globalVar = TSFE:page|nav_hide != 1]
//&& [globalVar = TSFE:beUserLogin = 0]
page.90 < plugin.tx_cscounterplus_pi1
[global]