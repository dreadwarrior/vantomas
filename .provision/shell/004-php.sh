#!/usr/bin/env bash

echo "Installing PHP..."

install_packages php5-fpm php5 php5-cli php5-curl php5-gd php5-json php5-mcrypt php5-mysql php5-sqlite php5-xdebug php5-xsl php5-apcu php5-intl

echo "Injecting PHP5 configuration..."

copy_configuration /etc/php5/cli/conf.d/01-php.ini "  CLI date.timezone setting"
copy_configuration /etc/php5/fpm/conf.d/00-php.ini "  php.ini overrides and additions"
copy_configuration /etc/php5/fpm/conf.d/06-opcache.ini "  opcache adjustments, see http://forge.typo3.org/issues/51475"
copy_configuration /etc/php5/fpm/conf.d/21-apcu.ini "  apcu setting"
copy_configuration /etc/php5/fpm/conf.d/21-xdebug.ini "  additional xdebug settings"
copy_configuration /etc/php5/fpm/pool.d/vagrant.conf "  adding our own pool"

echo "  removal of default FPM pool"
mv -f /etc/php5/fpm/pool.d/www.conf /etc/php5/fpm/pool.d/www.conf.bak

service php5-fpm restart
service nginx restart