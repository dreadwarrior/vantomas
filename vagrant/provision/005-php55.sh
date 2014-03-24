#!/usr/bin/env bash

echo "Updating PHP to version 5.5..."

# http://phpave.com/upgrade-php-5-3-php-5-5-ubuntu-12-04-lts/#.Uwn11cPUK1E
apt-get -y -qq install python-software-properties
add-apt-repository -y ppa:ondrej/php5
apt-get -y -qq update && apt-get -y -qq dist-upgrade