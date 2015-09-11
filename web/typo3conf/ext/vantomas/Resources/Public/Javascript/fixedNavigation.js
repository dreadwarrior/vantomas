;(function ($) {
	var
		getHeaderOffset = function() {
			var
				headerHeight = $('.w-header').height(),
				navigationHeight = $('.w-header nav .top-bar-section').height(),
				headerOffset = headerHeight - navigationHeight;

			return headerOffset;
		};

	$(window).scroll(function () {
		if ($(window).scrollTop() > getHeaderOffset()) {
			$('body').addClass('fixed-header');
		} else {
			$('body').removeClass('fixed-header');
		}
	});
})(window.jQuery || window.Zepto || window.$);