// simple content column height adjustment
;(function($) { 
	var swfObjects = 0;
	$('*[id*="mmswf"]').each(function(element) {
		swfObjects += 1;
	});

	if (($('#content').height() < $('sidebar').height()) && (swfObjects < 2)) {
		$('#content').css({ "height": $('sidebar').height() +'px' });
	}
})(jQuery);