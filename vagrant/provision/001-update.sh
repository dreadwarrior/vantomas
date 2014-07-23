#!/usr/bin/env bash

echo "Updating package sources..."

# @see http://serverfault.com/a/482740
# DEBIAN_FRONTEND=noninteractive * uses the default answer to any prompt.
export DEBIAN_FRONTEND=noninteractive

# Dpkg::Options::="--force-confdef" * ensures dpkg only overwrites config files you haven't modified
# Dpkg::Options::="--force-confold" * ensures the current config file is not overwritten. New config files are created with .dpkg-dist suffix.
${APT_GET_QUIET} -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" upgrade

${APT_GET_QUIET} update > /dev/null