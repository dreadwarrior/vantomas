#!/usr/bin/env bash

echo "Installing tools..."

apt-get -y -qq install git curl libxml2-utils
apt-get -y -qq install npm rubygems

npm install -g bower grunt-cli
gem install compass
gem install foundation