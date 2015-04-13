#!/usr/bin/env bash

echo "Installing nginx..."

install_package nginx

echo "  Removal of default host"
rm -f /etc/nginx/sites-enabled/default

copy_configuration /etc/nginx/sites-enabled/00-vagrant "  adding our own"
copy_configuration /etc/nginx/typo3-conf.d/ "  adding typo3-conf.d"