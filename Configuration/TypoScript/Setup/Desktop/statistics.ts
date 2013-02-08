lib.statistics {
	google = TEXT
	google.value (
	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
		var pageTracker = _gat._getTracker("{$site.google.analyticsid}");
		pageTracker._trackPageview();
	</script>
	)
	google.if.isTrue = {$statistics.google.enable}
}

[globalVar = TSFE:beUserLogin > 0]
lib.statistics.google.value >
[global]