// simple content column height adjustment
;(function($) { 
	var swfObjects = 0;
	$('*[id*="mmswf"]').each(function(element) {
		swfObjects += 1;
	});

	if (($('#content').height() < $('#sidebar').height()) && (swfObjects < 2)) {
		$('#content').css({ "height": $('#sidebar').height() +'px' });
	}

	// hide second child (after header)
	$('.box-shaded > div div:nth-child(2), .box-shaded > div ul').toggle();
	$('.box-shaded .csc-header').attr('title', 'Click to see what\'s in here.');

	/**
	 * adjusts the shaded box trigger height on mouse over
	 * 
	 * @param Element $target the shaded box element
	 */
	function adjustShadedBoxTriggerHeight($target) {
		var defaultSpace = 100;
		var iconSpace = 51;

		$headerContainer = $target.find('.csc-header');
		$header = $headerContainer.find('h3');
		// fetching width of header is only possible with this little hack
		$header.css({ "float": 'left', "width": 'auto' });

		var newHeight = $header.width() + defaultSpace + iconSpace;
		var transformOrigin = (newHeight - iconSpace) / 2;
		var transformOriginStr = transformOrigin + 'px '+ transformOrigin + 'px';

		$headerContainer.animate({
			"height": newHeight + 'px'
		}, 'fast', 'linear', function() {
			$header.css({
				"-moz-transform-origin": transformOriginStr, 
				"-webkit-transform-origin": transformOriginStr
			});
		});
	}

	/**
	 * adjusts the shaded box trigger height & show the content on click
	 *
	 * @param Element $target the shaded box element
	 * @param Element $content the content element of the shaded box 
	 */
	function adjustShadedBoxHeight($target, $content) {
		var defaultSpace = 150;
		var iconSpace = 51;

		$headerContainer = $target.find('.csc-header');
		headerContainerBGPos = $headerContainer.css('backgroundPosition').split(' ');
		$header = $headerContainer.find('h3');

		defaultSpace += $header.css({ "float": 'left', "width": 'auto' }).width();

		var heightAdjust = $content.outerHeight() + defaultSpace;
		var transformOrigin = (heightAdjust - iconSpace) / 2;
		var transformOriginStr = transformOrigin + 'px ' + transformOrigin + 'px';

		$target.height(heightAdjust);
		$headerContainer.animate({ "height": heightAdjust }, 'fast', 'linear', function() {
			$headerContainer.css(
				"backgroundPosition", 
				headerContainerBGPos[0] + ' ' + (heightAdjust - iconSpace) + 'px'
			);
			$header.css({
				"-moz-transform-origin": transformOriginStr,
				"-webkit-transform-origin": transformOriginStr
			});
			$content.slideDown('slow');
		});
	}

	/**
	 * rests the shaded box trigger height
	 * 
	 * @param Element $target the shaded box element
	 */
	function resetShadedBoxHeight($target) {
		$target.removeAttr('style');
		$target.find('.csc-header').removeAttr('style');
		$target.find('h3').removeAttr('style');
	}

	$('.box-shaded').mouseenter(function() {
		$this = $(this);

		adjustShadedBoxTriggerHeight($this);
	}).mouseleave(function() {
		$this = $(this);

		$this.find('.csc-header').stop().next().hide();

		resetShadedBoxHeight($this);
	}).click(function() {
		$this = $(this);
		$content = $this.find('.csc-header').next();

		adjustShadedBoxHeight($this, $content);
	});
})(jQuery);