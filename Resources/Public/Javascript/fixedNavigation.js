;(function ($) {
	var
		headerHeight = $('.w-header').height(),
		navigationHeight = $('.w-header nav').height(),
		headerOffset = headerHeight - navigationHeight,
		cssHash = {};

	$(window).scroll(function () {
		if ($(window).scrollTop() > headerOffset) {
			cssHash = {
				'top': '-' + headerOffset + 'px'
			};

			$('.w-header').css(cssHash);
			$('body').addClass('fixed-header');
		} else {
			$('.w-header').css(cssHash);
			$('body').removeClass('fixed-header');
		}
	});
})(jQuery);