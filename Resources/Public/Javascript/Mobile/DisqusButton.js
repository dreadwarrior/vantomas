$(document).on('click', '.disqus-init', function (event) {
	if ('undefined' === typeof DISQUS) {
		$.getScript('http://' + disqus_shortname + '.disqus.com/embed.js');
	} else {
		// @see https://xparkmedia.com/2012/04/disqus-comments-jquery-mobile
		if ($('#disqus_thread').length == 2) {
			$('.disqus-ajax:has(a)').removeAttr('id').empty();
		}

		DISQUS.reset({
			reload: true,
			config: function () {
				this.page.identifier = disqus_identifier;
				this.page.url = disqus_url;
			}
		});
	}
});