;(function ($) {
	var
		headerHeight = $('.w-header').height(),
		navigationHeight = $('.w-header nav').height(),
		headerOffset = headerHeight - navigationHeight;

	$(window).scroll(function () {
		if ($(window).scrollTop() > headerOffset) {
			$('body').addClass('fixed-header');
		} else {
			$('body').removeClass('fixed-header');
		}
	});
})(jQuery);