lib.fce.disqus {
	renderObj = TEMPLATE
	renderObj.template = TEXT
	renderObj.template.value (
<div id="disqus_thread"></div>
<script type="text/javascript">
		/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		var disqus_shortname = 'van-tomas-de';

		// The following are highly recommended additional parameters. Remove the slashes in front to use.
		var disqus_identifier = '###IDENTIFIER###';
		var disqus_url = '###URL###';

		/* * * DON'T EDIT BELOW THIS LINE * * */
		(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
	)
	renderObj.marks {
		IDENTIFIER = TEXT
		IDENTIFIER.data = page:uid
		IDENTIFIER.wrap = page_comment_
		URL = TEXT
		URL.typolink.parameter.data = page:uid
		URL.typolink.returnLast = url
		URL.wrap = http://www.van-tomas.de/
	}
}
