#!/bin/sh

set -e

mysql -u "${MYSQL_USER}" -p"${MYSQL_PASSWORD}" "$@"
