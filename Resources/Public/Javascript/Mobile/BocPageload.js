$(document).on('pageload', function (event, data) {
	var
		bocLibraryLoaded = 'undefined' !== $.beautyOfCode,
		bocPluginExists = 0 !== $('.tx_beautyofcode_pi1').length,
		beautyOfCodeLibrary = data.xhr.getResponseHeader('X-Beautyofcode-Library'),
		beautyOfCodeScript = data.xhr.getResponseHeader('X-Beautyofcode-Inline');

	if (/*false === bocLibraryLoaded
			&&*/ bocPluginExists
			&& '' !== beautyOfCodeLibrary
			&& '' !== beautyOfCodeScript) {
		$.getScript(beautyOfCodeLibrary).done(function () {
			$.getScript(beautyOfCodeScript);
		});
	}
});