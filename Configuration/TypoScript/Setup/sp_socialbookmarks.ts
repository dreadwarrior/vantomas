plugin.tx_spsocialbookmarks_pi1 {
  useTSTitle = 1
  pageTitle = TEXT
  pageTitle {
    field = sub_title // title
  }

  useDefaultTemplate = 0
  templateFile = EXT:sp_socialbookmarks/res/template/template.html
  stylesheetFile  = EXT:sp_socialbookmarks/res/template/stylesheet.css
  javascriptFile  = fileadmin/templates/{$site.template_path}/js/socialbookmarks.js


  serviceList = delicious,stumbleupon,twitter,facebook
  services {
    delicious.image = fileadmin/templates/{$site.template_path}/img/social_icons/delicious_doodle_64x64.png
    stumbleupon.image = fileadmin/templates/{$site.template_path}/img/social_icons/stumbleupon_doodle_64x64.png
    twitter.image = fileadmin/templates/{$site.template_path}/img/social_icons/twitter_doodle_64x64.png
    facebook.image = fileadmin/templates/{$site.template_path}/img/social_icons/facebook_doodle_64x64.png
  }

  // -- CSS styles for the social bookmark toolbar is loaded from "Blog"
  _CSS_DEFAULT_STYLE >
}
