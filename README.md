# vantomas

A TYPO3.CMS project encapsulating the website www.van-tomas.de

## Build status

[![Build Status](https://travis-ci.org/dreadwarrior/vantomas.svg?branch=master)](https://travis-ci.org/dreadwarrior/vantomas)

## Table of contents

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Prerequisites](#prerequisites)
  - [.env file](#env-file)
- [Installation](#installation)
- [Build](#build)
- [Release](#release)
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

The **provision**, **build**, **downsync** and **deploy** processes uses `ansible`.
Please ensure it's installed on your host machine.

**TL;DR**

  -  VirtualBox ~5.0.10
  -  vagrant ~1.7.4
  -  ansible ~1.9.4

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

    ~ $ ansible-playbook ./.ansible/playbooks/provision.yml

## Build

    ~ $ ansible-playbook .ansible/playbooks/build.yml

## Release

The release defaults to [Pull releases](docs/Release-Pull.md) with Travis.

You can [Push release](docs/Release-Push.md) if you're not using a Continuous Integration system.

## Syncing

Please read the [Release Inventory](docs/Release-Pull.md#inventories) chapter and make sure you created proper
inventory groups as they are important also for downsyncing data from remotes.

After that you're able to downsync database and files with the following command:

    ~$ ansible-playbook .ansible/playbooks/downsync-data.yml -i .ansible/inventories/nicknack_<testing|production>

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

        ```
        ansible-playbook playbook.yml --list-hosts
        ```

  2.  ...compare remote and local directory to check rsync deployment

        ```
        diff <(ssh user@host ls -R /path/to/remote/folder/) <(ls -R /path/of/local/folder/) > diff.log
        ```

  2.  ...compare remote and local directory to check rsync deployment

        diff <(ssh user@host ls -R /path/to/remote/folder/) <(ls -R /path/of/local/folder/) > diff.log

  3.  ...get the latest annotated tag which targets only the current commit in the current branch?

        git describe --exact-match --abbrev=0

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
