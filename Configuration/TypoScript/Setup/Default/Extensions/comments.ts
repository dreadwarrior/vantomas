plugin.tx_comments_pi1 {
	requiredFields = firstname,email,content

	spamProtect {
		honeypot = homepage
		notificationEmail = tommy@van-tomas.de
		fromEmail = tommy@van-tomas.de
	}

	advanced {
		#dateFormatMode = strftime
		# February 18th, 2010	1:27am
		#dateFormat = %B %e, %Y %I:%M%p
		dateFormatMode = date
		dateFormat = F jS, Y h:ia
	}

	// -- CSS_DEFAULT_STYLE is loaded from "Blog" and below...
	_CSS_DEFAULT_STYLE >

	_LOCAL_LANG {
		default {
			pi1_template.required_field = Make sure you enter the <strong>* required</strong> information where indicated. Comments are moderated – and rel="nofollow" is in use. Please no link dropping, no keywords or domains as names; do not spam, and do not advertise!
			pi1_template.first_name = First name
			pi1_template.last_name = Last name
			pi1_template.email = E-mail
			pi1_template.web_site = Web site
			pi1_template.location = Location
			pi1_template.submit = Post a comment
			pi1_template.reset = Reset form input
			pi1_template.content = Message
		}
	}
}