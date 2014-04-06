#!/usr/bin/env bash

echo "Installing tools..."

apt-get -y -qq install git curl libxml2-utils
apt-get -y -qq install nodejs npm rubygems

# @see http://justinvoelkel.me/problem-solved-foundation-5-cant-find-nodejs/
ln -f -s /usr/bin/nodejs /usr/bin/node

npm install -g bower grunt-cli
gem install compass
gem install foundation