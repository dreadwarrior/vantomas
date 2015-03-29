========
vantomas
========

A TYPO3.CMS project encapsulating the website www.van-tomas.de

Build status
-----------

.. image:: https://travis-ci.org/dreadwarrior/vantomas.svg?branch=master
    :target: https://travis-ci.org/dreadwarrior/beautyofcode

Installation
------------

.. code:: sh

   ~ $ php composer.phar create-project -s dev dreadlabs/vantomas
   ~ $ cd vantomas
   ~ $ vagrant up

Prerequisites
-------------

To run the project locally, make sure you have installed VirtualBox and vagrant.

Please activate ssh agent forwarding and SSH key authentification on the remote
server if you want to make use of database/file syncing or rsync deployment.

Furthermore, you must create a build.*.secret.properties file which keeps some
secret configuration settings. Please see the following section.

Secret properties
-----------------

To protect some sensitive data of the public eye a build properties file must be
created in the project's root directory: ''build.[stage].secret.properties''. This is
the template if you want to use the shipped build scripts:

.. code:: ini

   ssh.host=
   ssh.user=
   ssh.port=
   remote.path=

   google.webmastertools.activationcode=

   disqus.apiKey=

   twitter.consumerKey=
   twitter.consumerSecret=

   database.name=
   database.host=
   database.password=
   database.port=
   database.username=

   security.encryption.key=
   security.install_tool_password=

   hosting.image_magick.putenv=

   TYPO3_CONF_VARS.SYS.binPath=

   mailer.contactform.sender.mail=
   mailer.contactform.sender.name=

   mailer.contactform.receiver.mail=
   mailer.contactform.receiver.name=

   basic_auth.user=
   basic_auth.password=

Build
-----

.. code:: sh

   ~ $ cd /vagrant
   ~ $ php vendor/bin/phing -Denvironment=[dev|prod]

Release
-------

Currently only a rsync release process is implemented:

.. code:: sh

   ~ $ cd /vagrant
   ~ $ php vendor/bin/phing release -Drelease.target=[test|prod]

Syncing
-------

Currently the sync process supports downloading the database (without re-import
on the local machine) and downloading files out of `fileadmin/`.

**To fetch the database from the `prod` remote host**:

.. code:: sh

   ~ $ cd /vagrant
   ~ $ php vendor/bin/phing sync:db -Denvironment=prod


**To fetch the files (fileadmin/) from the `test` remote host**:

.. code:: sh

   ~ $ cd /vagrant
   ~ $ php vendor/bin/phing sync:files -Denvironment=test

Todo
----

Evaluate integration of http://serverfault.com/a/316100 (ssh-keygen / ssh-keyscan for ~/.ssh/known_hosts)


License
-------

The following directories and their contents are Copyright Thomas Juhnke. You
may not reuse anything therein without my permission:

- src/vantomas/Resources/Public/Images/ (except child folders)


**Photo credit `src/vantomas/Resources/Public/Images/sleeping-kittens.jpg`:**

`sleeping kittens <https://www.flickr.com/photos/96828128@N02/14447262431>`_ by `Jimmy B <https://www.flickr.com/photos/96828128@N02/>`_, `CC licensed <https://creativecommons.org/licenses/by/2.0/>`_

All other directories and files are GPL v2 Licensed. Feel free to use the HTML
and CSS as you please. If you do use them, a link back to
http://github.com/dreadwarrior/vantomas would be appreciated, but is not required.
