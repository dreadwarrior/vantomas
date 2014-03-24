#!/usr/bin/env bash

echo "Installing nginx..."

apt-get -y -qq install nginx

# removal of default host
rm -f /etc/nginx/sites-enabled/default
# adding our own
ln -s /vagrant/vagrant/config/nginx/vagrant /etc/nginx/sites-enabled/00-vagrant