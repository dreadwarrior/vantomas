# vantomas

A TYPO3.CMS project encapsulating the website www.van-tomas.de

## Build status

[![Build Status](https://travis-ci.org/dreadwarrior/vantomas.svg?branch=master)](https://travis-ci.org/dreadwarrior/vantomas)

## Prerequisites

To run the project locally, make sure you have installed VirtualBox and vagrant.

Please activate ssh agent forwarding and SSH key authentification on the remote
server if you want to make use of database/file syncing or rsync deployment.

The **provision**, **setup** and **build** process uses `ansible`. Please ensure
it's installed on your host machine.

Furthermore, you must create a secret ansible `group_vars` file which holds some 
secret  configuration settings. Please see the following section.

### Secret group vars

To protect sensitive data from the public a secret group_vars file must be created 
in the directory `.ansible/playbooks/group_vars/[group]`: "secrets.yml". This is
the template if you want to use the shipped release  procedure empowered by the 
[bytepark release tool](http://github.com/bytepark/release):

    release:
      ssh:
        user:
        host:
        port:

      database:
        remote:
          host:
          username:
          password:
          # database name
          name:

      # no trailing slash!
      path: /fully/qualified/path/to/remote/project/dir

### .env file

The project is operating with environment files in order to separate code from 
configuration. See the file `.env.dist` shipped with this project, adjust to your
needs and ensure it will be available from the project root directory.

For more information, read the [Config section](http://12factor.net/config) of the
"The Twelve Factor App" manifest. For a controversial consideration, please read
[Environment Variables Considered Harmful for Your Secrets](http://movingfast.io/articles/environment-variables-considered-harmful/).

## Installation

    ~ $ php composer.phar create-project -s dev dreadlabs/vantomas
    ~ $ cd vantomas
    ~ $ vagrant up

**Hint**: to re-run provision, you can do so by executing one of the following commands:

    ~ $ vagrant provision

or

    ~ $ ansible-playbook --limit development ./.ansible/playbooks/provision.yml

### Setup

Please ensure, you've created a proper secret group vars file for the `development` group, 
then execute the following command:

    ~ $ ansible-playbook .ansible/playbooks/setup.yml

## Build

    ~ $ ansible-playbook .ansible/playbooks/build.yml

## Release

The release process uses the [bytepark release manager](https://github.com/bytepark/release).

By default, the `deploy` method (rsync) is pre-configured.

You must properly setup the project, because the release process uses dependencies
from the project directory (`phing`, `dreadlabs/typo3-build`) which can't be installed
during the release process in order to keep the deployed dependencies clean (`--no-dev`).

    ~ $ cd /vagrant
    ~ $ release

### Basic auth protection

If you want to protect one or more stages with basic auth you have to add the following lines
to the secret group_vars file:

    ---
    basic_auth:
      users:
        - { user: USERNAME_1, password: PASSWORD_HASH_1 }
        - { user: USERNAME_2, password: PASSWORD_HASH_2 }

The password hash can be generated with the following commands:

    ~ $ sudo apt-get install apache2-utils
    ~ $ htpasswd -n USERNAME

## Syncing

Downsyncing files and database dumps from a remote target host is provided by the
`dump` method of the [bytepark release manager](https://github.com/bytepark/release>).

    ~ $ cd /vagrant
    ~ $ # select "Dump data from remote site" of the first dialog screen
    ~ $ release

## Running phinx migration from cli

The `phinx.yml` makes usage of the environment variables described in the `.env file`
section. To source the variables and execute phinx you can issue one of the following commands:

    # posix shell
    #
    # The -a switch exports all variables, so that they are available to the program.
    #
    # @source: http://serverfault.com/a/540484
    #
    ~ $ sh -ac '. ./.env; vendor/bin/phinx command [options] [arguments]'

    # bash
    #
    # @source: http://stackoverflow.com/a/30969768
    #
    ~ $ bash -c 'set -o allexport; source .env; vendor/bin/phinx command [options] [arguments]'

## Todo

Evaluate integration of http://serverfault.com/a/316100 (ssh-keygen / ssh-keyscan for ~/.ssh/known_hosts)

## License

The following directories and their contents are Copyright Thomas Juhnke. You
may not reuse anything therein without my permission:

- src/vantomas/Resources/Public/Images/ (except child folders)


**Photo credit `src/vantomas/Resources/Public/Images/sleeping-kittens.jpg`:**

[sleeping kittens](https://www.flickr.com/photos/96828128@N02/14447262431) by 
[Jimmy B](https://www.flickr.com/photos/96828128@N02/), 
[CC licensed](https://creativecommons.org/licenses/by/2.0/)

All other directories and files are GPL v2 Licensed. Feel free to use the HTML
and CSS as you please. If you do use them, a link back to
http://github.com/dreadwarrior/vantomas would be appreciated, but is not required.
