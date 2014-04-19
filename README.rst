========
vantomas
========

A TYPO3.CMS project encapsulating the website www.van-tomas.de

Secret properties
-----------------

To protect some sensitive data of the public eye a build properties file must be
created in the project's root directory: ''secret.[stage].properties''. This is 
the template if you want to use the shipped build scripts:

.. code:: ini

   google.webmastertools.activationcode=
   google.apikey=
   google.analyticsid=
   
   twitter.consumerKey=
   twitter.consumerSecret=
   
   disqus.apiKey=
   
   database.name=
   database.host=
   database.password=
   database.port=
   database.username=
   
   security.encryption.key=
   security.install_tool_password=
   
   hosting.image_magick.putenv=
   
   TYPO3_CONF_VARS.SYS.binPath=/usr/bin
   
   mailer.contactform.sender.mail = 
   mailer.contactform.sender.name = 
   
   mailer.contactform.receiver.mail = 
   mailer.contactform.receiver.name = 

Build
-----

.. code:: sh

   ~ $ /usr/bin/env npm install
   ~ $ /usr/bin/env bower install
   ~ $ php composer.phar update --no-plugins
   ~ $ php vendor/bin/phing -Denvironment=[dev|prod]

License
-------

The following directories and their contents are Copyright Thomas Juhnke. You 
may not reuse anything therein without my permission:

- src/vantomas/Resources/Public/Images/ (except child folders)

All other directories and files are MIT Licensed. Feel free to use the HTML and 
CSS as you please. If you do use them, a link back to 
http://github.com/dreadwarrior/vantomas would be appreciated, but is not required.