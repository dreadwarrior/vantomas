#!/usr/bin/env bash

echo "Installing nginx..."

install_package nginx

echo "  Removal of default host"
rm -f /etc/nginx/sites-enabled/default

link_configuration /etc/nginx/sites-enabled/00-vagrant "  adding our own"