# vantomas

A TYPO3.CMS project encapsulating the website www.van-tomas.de

## Build status

[![Build Status](https://travis-ci.org/dreadwarrior/vantomas.svg?branch=master)](https://travis-ci.org/dreadwarrior/vantomas)

## Table of contents

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Prerequisites](#prerequisites)
  - [Secret group vars](#secret-group-vars)
  - [.env file](#env-file)
- [Installation](#installation)
  - [Setup (finalize installation)](#setup-finalize-installation)
- [Build](#build)
- [Release](#release)
  - [Inventory](#inventory)
  - [Application cache cleanup](#application-cache-cleanup)
  - [Basic auth protection](#basic-auth-protection)
- [Syncing](#syncing)
- [Running phinx migration from cli](#running-phinx-migration-from-cli)
- [Todo](#todo)
- [How to...](#how-to)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Prerequisites

To run the project locally, make sure you have installed VirtualBox and vagrant.

Please activate ssh agent forwarding and SSH key authentification on the remote
server if you want to make use of database/file syncing or rsync deployment.

The **provision**, **setup** and **build** process uses `ansible`. Please ensure
it's installed on your host machine.

Furthermore, you must create a secret ansible `group_vars` file which holds some
secret  configuration settings. Please see the following section.

**TL;DR**

  -  VirtualBox ~5.0.10
  -  vagrant ~1.7.4
  -  ansible ~1.9.4

### Secret group vars

To protect sensitive data from the public a secret group_vars file must be created
in the directory `.ansible/playbooks/group_vars/[group]`: "secrets.yml". This is
the template if you want to use the shipped release procedure:

    ---

    # no trailing slash!
    deploy_to: /fully/qualified/path/to/remote/project/dir

    release_database_remote_host:
    release_database_remote_username:
    release_database_remote_password:
    # database name
    release_database_remote_name:

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

### Setup (finalize installation)

Please ensure, you've created a proper secret group vars file for the `development` group,
then execute the following command:

    ~ $ ansible-playbook --limit development .ansible/playbooks/setup.yml

## Build

    ~ $ ansible-playbook --limit development .ansible/playbooks/build.yml

## Release

First, you need to create an additional inventory file. Setup and build processes are covered
by the `hosts` inventory, which comes shipped with this project.

### Inventory

To do so, let's create this inventory. For example, you name your hosts by famous
[James Bond villains](https://en.wikipedia.org/wiki/List_of_James_Bond_villains). You
choose [Nick Nack](http://jamesbond.wikia.com/wiki/Nick_Nack) and so the remote host is called
`nicknack`. Let's create an inventory file:

    ~ $ cd /path/to/your/workspace/vantomas
    ~ $ touch .ansible/inventories/nicknack

The content has to look like the following. Please ensure to replace all values wrapped in `%`
with the appropriate values.

    [testing]
    test.example.org    ansible_connection=ssh    ansible_ssh_host=%NICK_NACK_IP%    ansible_ssh_port=%NICK_NACK_SSH_PORT%    ansible_ssh_user=%NICK_NACK_USER%
    development    ansible_connection=ssh    ansible_ssh_host=127.0.0.1    ansible_ssh_port=2222    ansible_ssh_user=vagrant    ansible_ssh_private_key_file=.vagrant/machines/default/virtualbox/private_key

    [production]
    www.example.org     ansible_connection=ssh    ansible_ssh_host=%NICK_NACK_IP%    ansible_ssh_port=%NICK_NACK_SSH_PORT%    ansible_ssh_user=%NICK_NACK_USER%
    development    ansible_connection=ssh    ansible_ssh_host=127.0.0.1    ansible_ssh_port=2222    ansible_ssh_user=vagrant    ansible_ssh_private_key_file=.vagrant/machines/default/virtualbox/private_key

Each group must have a `development` entry because some actions during deploy are run in the
development machine (VirtualBox machine / container). The deployment process checks if the
working copy is clean, installs production-ready dependencies and finally uploads the
project by rsync to the remote host in the target group. Some parts of the release playbook
are run against the local project instance. This ensures reusage of already downloaded /
installed components (nvm / composer) and shifts the project into a "releasable state".

**Note**: The development entry must be changed to the following if the `deploy` playbook is
executed on a host where no virtual machine / container is in use. For example on a CI server
like Jenkins:

    development    ansible_connection=local

Add this file to your `.gitignore` because it contains some secret data:

    ~ $ echo "nicknack" >> .gitignore

Test your release inventory configuration:

    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack --list-hosts [--limit <production|testing>]
    > playbook: .ansible/playbooks/deploy.yml
    >
    >   play #1 (localhost): host count=1
    >     localhost
    >
    >   play #2 (all:!localhost): host count=1
    >     test.example.org

Execute the release playbook:

    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack --limit <production|testing>

### Application cache cleanup

During release, the TYPO3 cache is cleared in the filesystem (`typo3temp/Cache`) and in
the database (`cf_extbase_<reflection|object>[_tags]`). If you need to disable this just
say so by using the `extra-vars` argument of ansible:

    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack --limit <production|testing> --extra-vars "clear_cache=no"

You can combine this by targeting a specific cache only:

    # Clear file cache only
    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack --limit <production|testing> --extra-vars "clear_cache=no clear_cache_files=yes"
    # Clear database cache only
    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack --limit <production|testing> --extra-vars "clear_cache=no clear_cache_database=yes"

### Basic auth protection

If you want to protect one or more stages with basic auth you have to add the following lines
to the secret group_vars file:

    ---
    basic_auth_users:
      - { user: USERNAME_1, password: PASSWORD_HASH_1 }
      - { user: USERNAME_2, password: PASSWORD_HASH_2 }

The password hash can be generated with the following commands:

    ~ $ sudo apt-get install apache2-utils
    ~ $ htpasswd -n USERNAME

## Syncing

Please read the [Release Inventory](#inventory) chapter and make sure you created proper
inventory groups as they are important also for downsyncing data from remotes.

After that you're able to downsync database and files with the following command:

    ~$ ansible-playbook .ansible/playbooks/downsync-data.yml -i .ansible/inventories/nicknack --limit <production|testing>

You can split the process further down with using tags targeting a specific part of the downsync:

    ~$ ansible-playbook .ansible/playbooks/downsync-data.yml -i .ansible/inventories/nicknack --limit <production|testing> [-t <database|files>]

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

## How to...

  1.  ...see what hosts would be affected by a playbook before I run it?

        ansible-playbook playbook.yml --list-hosts

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
