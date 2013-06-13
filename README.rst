============
ext:vantomas
============

A TYPO3 extension which encapsulates the website www.van-tomas.de

Secret properties
-----------------

In hope to protect some sensitive data of the public eye I've introduced a file
''Build/Secret.properties''. This is the template if you want to use the shipped
build scripts:

.. code:: ini

	# FQ path to the php executable
	php.executable=/fully/qualified/path/to/php_binary

	compass.executable=/fully/qualified/path/to/compass_binary

	project.root.prefix=/fully/qualified/path/to/the/document/root/

	# target deploy path (e.g. typo3Instance/typo3conf/ext/vantomas'
	target.path=${project.root.prefix}path/suffix/to/production/environment

	# path to the current TYPO3 instance (e.g. typo3Instance2/typo3)
	typo3.basedir=${project.root.prefix}path/suffix/to/development/environment

	google.webmastertools.activationcode=
	google.apikey=
	google.analyticsid=

	disqus.shortname=

License
---------

The following directories and their contents are Copyright Thomas Juhnke. You may not reuse anything therein without my permission:

- Resources/Public/Images/ (except child folders)

All other directories and files are MIT Licensed. Feel free to use the HTML and CSS as you please. If you do use them, a link back to http://github.com/dreadwarrior/vantomas would be appreciated, but is not required.