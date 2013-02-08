plugin.tx_spsocialbookmarks_pi1 {
	useTSTitle = 1
	pageTitle = TEXT
	pageTitle {
		field = sub_title // title
	}

	useDefaultTemplate = 0
	templateFile = EXT:sp_socialbookmarks/res/template/template.html
	stylesheetFile = EXT:sp_socialbookmarks/res/template/stylesheet.css
	javascriptFile = typo3conf/ext/vantomas/Resources/Public/Javascript/Desktop/socialbookmarks.js


	serviceList = delicious,stumbleupon,twitter,facebook
	services {
		delicious.image = typo3conf/ext/vantomas/Resources/Public/Images/Desktop/social_icons/delicious_doodle_64x64.png
		stumbleupon.image = typo3conf/ext/vantomas/Resources/Public/Images/Desktop/social_icons/stumbleupon_doodle_64x64.png
		twitter.image = typo3conf/ext/vantomas/Resources/Public/Images/Desktop/social_icons/twitter_doodle_64x64.png
		facebook.image = typo3conf/ext/vantomas/Resources/Public/Images/Desktop/social_icons/facebook_doodle_64x64.png
	}

	// -- CSS styles for the social bookmark toolbar is loaded from "Blog"
	_CSS_DEFAULT_STYLE >
}