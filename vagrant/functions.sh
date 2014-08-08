#!/usr/bin/env bash

# ------------------------------------------------------------------------------
# install_package ()
#
# installs one ore more packages
#
# Returns: void
# ------------------------------------------------------------------------------
function install_package() {
  echo "Installing package(s) ${*}"

  ${APT_GET_QUIET} install $* >/dev/null
}

# ------------------------------------------------------------------------------
# install_packages ()
#
# installs one ore more packages, alias for install_package()
#
# Returns: void
# ------------------------------------------------------------------------------
function install_packages() {
  install_package $*
}

# ------------------------------------------------------------------------------
# link_configuration ()
#
# links a configuration file from project configuration into VM
#
# Parameter 1: $source_within_project_vagrant_directory (e.g. /etc/php5/cli/conf.d/00-php.ini)
# Parameter 2: $message
# Returns: void
# ------------------------------------------------------------------------------
function link_configuration() {
  SOURCE="${CONFIG_DIR}$1"
  TARGET="$1"
  MESSAGE="$2"

  if [ ! -z "${MESSAGE}" ]; then
    echo ${MESSAGE}
  fi

  ln -f -s ${SOURCE} ${TARGET}
}