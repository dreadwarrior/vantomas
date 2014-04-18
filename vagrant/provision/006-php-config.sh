#!/usr/bin/env bash

echo "Injecting PHP5 configuration..."

# date.timezone setting
ln -f -s /vagrant/vagrant/config/php5-cli/conf.d/01-php.ini /etc/php5/cli/conf.d/01-php.ini 

# php.ini overrides
ln -f -s /vagrant/vagrant/config/php5-fpm/conf.d/00-php.ini /etc/php5/fpm/conf.d/00-php.ini
# opcache adjustments, see http://forge.typo3.org/issues/51475
ln -f -s /vagrant/vagrant/config/php5-fpm/conf.d/06-opcache.ini /etc/php5/fpm/conf.d/06-opcache.ini
# additional xdebug settings
ln -f -s /vagrant/vagrant/config/php5-fpm/conf.d/21-xdebug.ini /etc/php5/fpm/conf.d/21-xdebug.ini

# removal. of default pool
mv -f /etc/php5/fpm/pool.d/www.conf /etc/php5/fpm/pool.d/www.conf.bak
# adding our own pool
ln -f -s /vagrant/vagrant/config/php5-fpm/pool.d/vagrant.conf /etc/php5/fpm/pool.d/vagrant.conf

service php5-fpm restart
service nginx restart