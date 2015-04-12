#!/usr/bin/env bash

echo "Installing tools..."

install_packages graphicsmagick git curl libxml2-utils xsltproc
install_packages nodejs npm

# @see http://justinvoelkel.me/problem-solved-foundation-5-cant-find-nodejs/
echo "  Creating /usr/bin/node symlink"
ln -f -s /usr/bin/nodejs /usr/bin/node

echo "  Installing compass + foundation"
gem install compass foundation --no-verbose >/dev/null