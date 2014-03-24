#!/usr/bin/env bash

echo "Installing MySQL..."

# or: export DEBIAN_FRONTEND=noninteractive
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password typo3'
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password typo3'

apt-get -y -qq install mysql-server