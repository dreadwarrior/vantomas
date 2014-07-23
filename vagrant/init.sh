#!/usr/bin/env bash

# ------------------------------------------------------------------------------
# init_node_and_bower_packages ()
#
# initializes the node.js and bower packages
#
# Returns: void
# ------------------------------------------------------------------------------
function init_node_and_bower_packages() {

  sudo -u vagrant /usr/bin/env npm install
  sudo -u vagrant /usr/bin/env bower install

}

# ------------------------------------------------------------------------------
# init_composer ()
#
# initializes the composer packages; updates composer.phar if found, installs
# otherwise
#
# Returns: void
# ------------------------------------------------------------------------------
function init_composer() {

  if [ -a composer.phar ]; then
    /usr/bin/env php composer.phar self-update
  else
    curl -sS https://getcomposer.org/installer | php
  fi

  /usr/bin/env php composer.phar install
}

# ------------------------------------------------------------------------------
# init_database ()
#
# initializes the database
#
# Returns: void
# ------------------------------------------------------------------------------
function init_database() {

  mysql -uroot -ptypo3 -hlocalhost -e 'CREATE DATABASE IF NOT EXISTS typo3 CHARACTER SET utf8 COLLATE utf8_general_ci;'

  if [ -a /vagrant/data/db/dump.sql ]; then
    mysql -uroot -ptypo3 -hlocalhost typo3 < /vagrant/data/db/dump.sql
  else
    echo 'No database dump found. Please create one and import it manually.'
  fi

}

if [ ! -a ${ROOT_DIR}/.initialized ]; then

  cd /vagrant

  init_node_and_bower_packages
  init_composer
  init_database

  touch ${ROOT_DIR}/.initialized

fi