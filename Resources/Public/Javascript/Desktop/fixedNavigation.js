;(function ($) {
	var
		navigationHeight = $('nav').height(),
		mainMenuHeight = $('#menu-main').height(),
		navigationBarOffset = navigationHeight - mainMenuHeight,
		cssHash = {};

	$(window).scroll(function () {
		if ($(window).scrollTop() > navigationBarOffset) {
			cssHash = {
				'top': '-' + navigationBarOffset + 'px'
			};

			$('nav').css(cssHash);
			$('#wrap').addClass('fixed');
		} else {
			$('nav').css(cssHash);
			$('#wrap').removeClass('fixed');
		}
	});
})(jQuery);