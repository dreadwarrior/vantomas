#!/usr/bin/env bash

JENKINS_CLI="/home/vagrant/jenkins-cli.jar"
JENKINS_CLI_CMD="java -jar ${JENKINS_CLI} -s http://localhost:8080"
JENKINS_PLUGINS="git checkstyle cloverphp crap4j dry htmlpublisher jdepend plot pmd violations xunit"
JENKINS_PHP_TEMPLATE="https://raw.githubusercontent.com/sebastianbergmann/php-jenkins-template/master/config.xml"
JENKINS_PHP_TEMPLATE_DIR="/var/lib/jenkins/jobs/php-template"

# ------------------------------------------------------------------------------
# update_jenkins_updatecenter ()
#
# Updates the jenkins update center
#
# Parameter 1: Method, either 'curl' or 'lowlevel'
#
# Returns: void
# ------------------------------------------------------------------------------
function update_jenkins_updatecenter () {
  METHOD="$1"
  REMOTE_UPDATE_URL="http://updates.jenkins-ci.org/update-center.json"
  LOCAL_UPDATE_URL="http://localhost:8080/updateCenter/byId/default/postBack"

  case "${METHOD}" in

    "lowlevel" )
      wget ${REMOTE_UPDATE_URL} -O /tmp/jenkins-update-center-default.js
      sed '1d;$d' /tmp/jenkins-update-center-default.js > /tmp/jenkins-update-center-default.json
      mkdir -p /var/lib/jenkins/updates
      mv -f /tmp/jenkins-update-center-default.json /var/lib/jenkins/updates/
      chown -R jenkins:jenkins /var/lib/jenkins/updates
      service jenkins restart
      rm -f /tmp/jenkins-update-center.*
      ;;

    # NOTE: this method doesn't work for me after installing jenkins
    # The Problem is the same as for the CLI jar download: Jenkins responses
    #+ with "Please wait while Jenkins getting ready to work..."
    "curl"     )
      # download | delete first and last line | post to local jenkins instance
      curl -L ${REMOTE_UPDATE_URL} | sed '1d;$d' | curl -X POST -H 'Accept: application/json' -d @- ${LOCAL_UPDATE_URL}
      ;;

    *          )
      echo "No valid method (curl or lowlevel) was specified to update the Jenkins update center!"
      ;;

  esac
}

# ------------------------------------------------------------------------------
# get_jenkins_cli ()
#
# Gets the jenkins cli either by download or extract method.
#
# Parameter 1: Method, either "download" or "extract"
# Parameter 2: Path to .jar file output
# Returns: void
# ------------------------------------------------------------------------------
function get_jenkins_cli () {
  METHOD="$1"
  OUT="$2"

  case "${METHOD}" in

    "download" )
      # Can't get this to work. Response shows "Please wait while jenkins is getting ready to work..."
      curl -L http://localhost:8080/jnlpJars/jenkins-cli.jar -o ${OUT}
      ;;

    "extract" )
      # install_package unzip
      unzip -qqc /usr/share/jenkins/jenkins.war WEB-INF/jenkins-cli.jar > ${OUT}
      ;;

    *         )
      echo "No valid method (download or extract) was specified to fetch the jenkins-cli.jar!"
      ;;

  esac
}

# ------------------------------------------------------------------------------
# install_jenkins_template ()
#
# Installs the Jenkins PHP Template for Jenkins
#
# Parameter 1: Method, either 'cli' or 'shell'.
#
# Returns: void
# ------------------------------------------------------------------------------
function install_jenkins_template () {
  METHOD="$1"

  case "${METHOD}" in

    "cli"   )
      curl -L ${JENKINS_PHP_TEMPLATE} | ${JENKINS_CLI_CMD} create-job php-template
      ;;

    "shell" )
      mkdir -p ${JENKINS_PHP_TEMPLATE_DIR}
      wget ${JENKINS_PHP_TEMPLATE} -O ${JENKINS_PHP_TEMPLATE_DIR}/config.xml
      chown -R jenkins:jenkins ${JENKINS_PHP_TEMPLATE_DIR}/
      ;;

    *       )
      echo "No valid method (cli or shell) was specified to install the jenkins template!"
      ;;

  esac
}

echo "Installing Jenkins"
# install_package jenkins

update_jenkins_updatecenter lowlevel

if [[ ! -a ${JENKINS_CLI} ]]; then
  echo "  Installing Jenkins for PHP QA"

  get_jenkins_cli extract ${JENKINS_CLI}

  ${JENKINS_CLI_CMD} install-plugin ${JENKINS_PLUGINS}

  install_jenkins_template cli

  ${JENKINS_CLI_CMD} safe-restart
fi