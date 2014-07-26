#!/usr/bin/env bash

echo "Installing tools..."

install_packages graphicsmagick git curl libxml2-utils
install_packages nodejs npm

# @see http://justinvoelkel.me/problem-solved-foundation-5-cant-find-nodejs/
echo "  Creating /usr/bin/node symlink"
ln -f -s /usr/bin/nodejs /usr/bin/node

echo "  Installing bower + grunt-cli"
npm install -g -q bower grunt-cli

echo "  Installing compass + foundation"
gem install compass foundation --no-verbose

echo "  Installing Jenkins"
install_package jenkins

echo " Installing Jenkins for PHP QA"

JENKINS_CLI_CMD="java -jar jenkins-cli.jar -s http://localhost:8080"
JENKINS_PLUGINS="git checkstyle cloverphp crap4j dry htmlpublisher jdepend plot pmd violations xunit"
JENKINS_PHP_TEMPLATE="https://raw.github.com/sebastianbergmann/php-jenkins-template/master/config.xml"

if [[ ! -a /home/vagrant/jenkins-cli.jar ]]; then
  cd /home/vagrant
  wget http://localhost:8080/jnlpJars/jenkins-cli.jar
  ${JENKINS_CLI_CMD} install-plugin ${JENKINS_PLUGINS}

  # -- install php-template, method
  # curl ${JENKINS_PHP_TEMPLATE} | ${JENKINS_CLI_CMD} create-job php-template

  # -- install php-template, alternate method
  cd /var/lib/jenkins/jobs/
  mkdir php-template
  cd php-template
  wget ${JENKINS_PHP_TEMPLATE}
  cd ..
  chown -R jenkins:jenkins php-template/

  ${JENKINS_CLI_CMD} safe-restart
fi