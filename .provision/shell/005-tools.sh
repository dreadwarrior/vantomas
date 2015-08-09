#!/usr/bin/env bash

echo "Installing tools..."

install_packages graphicsmagick git curl libxml2-utils xsltproc dialog

echo "Installing bytepark release..."

if [ ! -d /opt/bytepark-release ]; then
  cd /opt
  git clone https://github.com/bytepark/release.git bytepark-release
  $(cd bytepark-release && git checkout 2.0.0)
  ln -s /opt/bytepark-release /opt/release
  ln -s /opt/bytepark-release/release.sh /usr/local/bin/release
fi
