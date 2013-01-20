<INCLUDE_TYPOSCRIPT: source="FILE:EXT:form/Configuration/TypoScript/setup.txt">

temp.form.request {
	# Standard-Werte für E-Mailempfänger, Reply-To etc.
	defaultValues {
		emailSender = CASE
		emailSender {
			key = {$form.request.emailSender}
			# es kann aus dem Formularfeld ausgelesen werden
			fromField = TEXT
			fromField.data = GP:email
			# oder "hart" als Konstante eingegeben werden
			default = TEXT
			default.value = {$form.request.emailSender}
		}
		emailReplyTo = CASE
		emailReplyTo {
			key = {$form.request.emailReplyTo}
			# es kann aus dem Formularfeld ausgelesen werden
			fromField = TEXT
			fromField.data = GP:email
			default = TEXT
			default.value = {$form.request.emailReplyTo}
		}
	}
}

plugin.tx_thmailformplus_pi1 {
	langFile = fileadmin/templates/{$site.template_path}/l10n/form-request.xml

	default {
		email_sender < temp.form.request.defaultValues.emailSender
		email_to = {$form.request.emailReceiver}
		email_replyto < temp.form.request.defaultValues.emailReplyTo

		email_subject = CASE
		email_subject {
			key = {$form.request.subjectType}
			# normale Betreffzeile
			normal = TEXT
			normal {
				value = Contact form at van-tomas.de, Subject: {GP:subject}
				insertData = 1
			}
		}
	}

	errorUserFunc = EXT:profi_helper/th_mailformplus/class.tx_profihelper_th_mailformplus_Validation.php:tx_profihelper_th_mailformplus_Validation->validate
	errorUserFunc {
		debug = 0
	}

	# @todo: sort like used in template file!
	markers {
		SELECT_COUNTRY_LONG = USER
		SELECT_COUNTRY_LONG {
			userFunc = tx_profihelper_th_mailformplus->buildCountrySelectList
			params {
				fieldId = country
				fieldName = country
				override {
					# allows to specify a country area, defaults to `ALL`
					#countryArea = ALL|UN|EU
					# allows to override current language, defaults to ``
					#lang = de
					# local = ?
					# allows to override the SQL-WHERE clause for table `static_countries`, defaults to ``
					#where =
				}
			}
		}

		# JavaScript für Betreff ("subject_other")
		JAVASCRIPT = COA
		JAVASCRIPT {
			10 = TEXT
			10.value (
		<script type="text/javascript">
		//<![CDATA[
			(function($) {
				$('#subject').change(function(event) {
					var inputFieldCont = $(this).parent('li').next('li');
					if ($(this).val() == 'other') {
						$(inputFieldCont).show();
					} else {
						$(inputFieldCont).hide();
					}
				});
				$(function(event) {
					var inputFieldCont = $('#subject').parent('li').next('li');
					if ($('#subject').val() == 'other') {
						$(inputFieldCont).show();
					} else {
						$(inputFieldCont).hide();
					}
				});
			})(jQuery);
		//]]>
		</script>
			)
		}
	}

	#captchaFieldname = captcha

	spamNotify = 1
	spamNotify {
		emailTo = tommy@van-tomas.de
		emailFrom = tommy@van-tomas.de
		subject = Spam suspect at contact form on van-tomas.de
		sendInfo {
			url = 1
			referer = 1
			submittedData = 1
		}
	}

	# field configuration
	# the `mapping` configuration key is an user-defined extension
	# which is process in the class.user_thMailformplusExtension.php script
	fieldConf {
		subject {
			errorCheck = required
			#defaultValue = request
			mapping {
				quesition = I have a question
				mistake = I found a mistake
				other = Other
			}
		}
		firstname {
			errorCheck = required
		}
		lastname {
			errorCheck = required
		}
		street {
			// errorCheck = required
		}
		zip {
			// errorCheck = required
		}
		country {
			// errorCheck = required
		}
		email {
			errorCheck = required,email
		}
		notes {
			errorCheck = required
		}
	}
}

/*
[globalVar = GP:L = 2]
plugin.tx_thmailformplus_pi1.markers.SELECT_COUNTRY_LONG.params.override.lang = it
plugin.tx_thmailformplus_pi1.markers.SELECT_COUNTRY_LONG.params.override.firstCountries {
	IT = Italia
	DE = Germania
	CH = Svizzera
	AT = Austria
}
[global]

[globalVar = GP:L = 3]
plugin.tx_thmailformplus_pi1.markers.SELECT_COUNTRY_LONG.params.override.lang = en
plugin.tx_thmailformplus_pi1.markers.SELECT_COUNTRY_LONG.params.override.firstCountries {
	UK = United Kingdom
	DE = Germany
	IT = Italy
	CH = Switzerland
	AT = Austria
}
[global]
*/
