// -- social bookmark toolbar CSS styles
plugin.tx_spsocialbookmarks_pi1 {
  _CSS_DEFAULT_STYLE (
    #sp_socialbookmarks_link_bar {
      background-image: url('http://static1.van-tomas.de/templates/{$site.template_path}/img/bg-social-icon-bar.png');
      background-position: 80% center;
      background-repeat: no-repeat;

      height: 67px;

      border-top: 1px solid #ffc096;
      border-bottom: 1px solid #ffc096;

      padding: 10px 0;
      margin-top: 10px;
    }
    #sp_socialbookmarks_link_bar img { border-top: 3px solid #ffffff; }
    #sp_socialbookmarks_link_bar a:hover img {
      border-top: 0;
      border-bottom: 3px solid #ffffff;
    }
  )
}
