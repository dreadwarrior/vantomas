;jQuery(function($) {
	return;
	var projectTemplate = '\
		<div class="project">\
			<div class="name">{{name}}</div>\
			<div class="description">{{description}}</div>\
			<div class="meta">\
				<ul>\
					<li>Last updated {{updated_at_HR}}</li>\
					<li>{{watchers}} Watchers</li>\
					<li>{{forks}} forks</li>\
					<li><a href="{{html_url}}">Project home</a></li>\
				</ul>\
			</div>\
		</div>\
	';

	var partials = {
		humanReadableDate: function() {
			return function(text, render) {
				return humanDate(text);
			}
		}
	};

	$.getJSON('https://api.github.com/users/dreadwarrior/repos?callback=?', function(json) {
		$.each(json.data, function(index, responseObj) {
			if (responseObj.size == 0) {
				return true;
			}

			responseObj.updated_at_HR = humaneDate(responseObj.updated_at);

			var projectHtml = Mustache.to_html(projectTemplate, responseObj, partials);
			$('#github-projects').append(projectHtml);
		});
	});
});