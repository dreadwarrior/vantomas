plugin.tx_vantomas {
	settings {
		twitter {
			consumerKey = ${twitter.consumerKey}
			consumerSecret = ${twitter.consumerSecret}

			bearerTokenUrl = https://api.twitter.com/oauth2/token

			userAgent = van-tomas.de Twitter App v1.0
			bearerCacheLifetime = 86400
		}
	}
}