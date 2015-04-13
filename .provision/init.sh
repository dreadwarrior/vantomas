#!/usr/bin/env bash

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

# @todo: evaluate http://stackoveraflow.com/a/17758312

if [ ! -a ${ROOT_DIR}/.initialized ]; then

  cd /vagrant

  init_database

  touch ${ROOT_DIR}/.initialized

fi