#!/usr/bin/env bash

echo "Installing PHP..."

apt-get -y -qq install php5-fpm php5 php5-cli php5-curl php5-gd php5-json php5-mcrypt php5-mysql php5-sqlite php5-xdebug php5-xsl

service php5-fpm restart
service nginx restart