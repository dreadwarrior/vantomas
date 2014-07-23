#!/usr/bin/env bash

ROOT_DIR="/vagrant/vagrant"
PROVISION_DIR="${ROOT_DIR}/provision"
CONFIG_DIR="${ROOT_DIR}/config"

# default apt-get command + options for quiet operation
APT_GET_QUIET="apt-get -y -qq"

source ${ROOT_DIR}/functions.sh

source ${PROVISION_DIR}/001-update.sh
source ${PROVISION_DIR}/002-httpd.sh
source ${PROVISION_DIR}/003-database.sh
source ${PROVISION_DIR}/004-php.sh
source ${PROVISION_DIR}/005-tools.sh
source ${PROVISION_DIR}/006-mail.sh

source ${ROOT_DIR}/init.sh