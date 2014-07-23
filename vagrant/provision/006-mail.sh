#!/usr/bin/env bash

echo "Installing postfix and mutt for local mail delivery"

debconf-set-selections <<< "postfix postfix/mailname string vagrant.localhost"
debconf-set-selections <<< "postfix postfix/main_mailer_type string 'Local only'"

install_packages postfix mutt