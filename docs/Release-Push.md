# Push releases

## Table of contents

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Introduction](#introduction)
- [Secret group vars file](#secret-group-vars-file)
- [Inventories](#inventories)
  - [Naming and contents](#naming-and-contents)
- [Application cache cleanup](#application-cache-cleanup)
- [Basic auth protection](#basic-auth-protection)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Introduction

If you're not using a [CI environment][ci] like [Jenkins][jenkins] or [Travis][travis] you can simply use the shipped
**push-deploy** playbook.

To use this, you have to create some special files. But its worth the effort because if you're developing Open Source
Software, you're moving around in a public development environment and don't want to share specific information like
directory structures, database credentials or other sensitive information.

## Secret group vars file

First, you must create a secret ansible `group_vars` file which holds secret configuration settings.

To protect sensitive data from the public the secret `group_vars` file "secrets.yml" must be created in the directory
`.ansible/playbooks/group_vars/[group]`. This is the template:

    ---

    # no trailing slash!
    deploy_to: /fully/qualified/path/to/remote/project/dir

    release_database_remote_host:
    release_database_remote_username:
    release_database_remote_password:
    # database name
    release_database_remote_name:

But basically, you can put every Ansible variable here which is used during the process.

You must create this file for every **stage** you want to deploy to. E.g. **testing**, **production**, etc.

## Inventories

While the provision, setup and build processes are covered by the `hosts` inventory, which comes shipped with this
project, you should create **separate** inventory files. This is important, if deployment targets the same hosts.

*(I know that this is a *bad practice* because normally you should have isolated environments for staging)*

For [more information][ansible_issue_9065] read [this][google_groups_multimachine_same_ip].

### Naming and contents

Lets assume, you name your hosts by famous [James Bond villains][james_bond_villains]. You choose [Nick Nack][nicknack]
and so the remote host is called `nicknack`. Let's create the inventory files:

    ~ $ cd /path/to/your/workspace/vantomas
    ~ $ touch .ansible/inventories/nicknack{_testing,_production}

The contents have to look like the following. Please ensure to replace all values wrapped in `%`
with the appropriate values.

    # .ansible/inventories/nicknack_testing
    [testing]
    test.example.org    ansible_connection=ssh    ansible_ssh_host=%NICK_NACK_IP%    ansible_ssh_port=%NICK_NACK_SSH_PORT%    ansible_ssh_user=%NICK_NACK_USER%
    development    ansible_connection=ssh    ansible_ssh_host=127.0.0.1    ansible_ssh_port=2222    ansible_ssh_user=vagrant    ansible_ssh_private_key_file=.vagrant/machines/default/virtualbox/private_key

    # .ansible/inventories/nicknack_production
    [production]
    www.example.org     ansible_connection=ssh    ansible_ssh_host=%NICK_NACK_IP%    ansible_ssh_port=%NICK_NACK_SSH_PORT%    ansible_ssh_user=%NICK_NACK_USER%
    development    ansible_connection=ssh    ansible_ssh_host=127.0.0.1    ansible_ssh_port=2222    ansible_ssh_user=vagrant    ansible_ssh_private_key_file=.vagrant/machines/default/virtualbox/private_key

Each group must have a `development` entry because some actions during deploy are run in the development machine
(VirtualBox machine / container). The deployment process checks if the working copy is clean, installs production-ready
dependencies and finally uploads the project by rsync to the remote host(s) in the target group. Some parts of the
release playbook are run against the local project instance. This ensures reusage of already downloaded / installed
components (nvm / composer) and shifts the project into a "releasable state".

**Note**: The development entry must be changed to the following if the `push-deploy` playbook is executed on a host
where no virtual machine / container is in use. For example on a CI server like Jenkins:

    development    ansible_connection=local

Add these files to your `.gitignore` because it contains some secret data:

    ~ $ echo "nicknack_testing" >> .gitignore
    ~ $ echo "nicknack_production" >> .gitignore

Test the deploy inventory configuration:

    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack_<testing|production> --list-hosts
    > playbook: .ansible/playbooks/deploy.yml
    >
    >   play #1 (localhost): host count=1
    >     localhost
    >
    >   play #2 (all:!localhost): host count=1
    >     test.example.org

Execute the **push-deploy** playbook:

    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack_<testing|production>

## Application cache cleanup

During release, the TYPO3 cache is cleared in the filesystem (`typo3temp/Cache`) and in the database
(`cf_extbase_<reflection|object>[_tags]`). If you need to disable this just say so by using the `extra-vars` argument
of ansible:

    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack_<testing|production> --extra-vars "clear_cache=no"

You can combine this by targeting a specific cache only:

    # Clear file cache only
    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack_<testing|production> --extra-vars "clear_cache=no clear_cache_files=yes"
    # Clear database cache only
    ~ $ ansible-playbook .ansible/playbooks/deploy.yml -i .ansible/inventories/nicknack_<testing|production> --extra-vars "clear_cache=no clear_cache_database=yes"

## Basic auth protection

If you want to protect one or more stages with basic auth you have to add the following lines to the secret group_vars
file:

    ---

    basic_auth_users:
      - { user: USERNAME_1, password: PASSWORD_HASH_1 }
      - { user: USERNAME_2, password: PASSWORD_HASH_2 }

The password hash can be generated with the following commands:

    ~ $ sudo apt-get install apache2-utils
    ~ $ htpasswd -n USERNAME

[ci]: https://en.wikipedia.org/wiki/Continuous_integration
[jenkins]: https://jenkins-ci.org/
[travis]: https://travis-ci.org/
[ansible_issue_9065]: https://github.com/ansible/ansible/issues/9065
[google_groups_multimachine_same_ip]: https://groups.google.com/forum/#!topic/ansible-project/fDMQhGuSt9A
[james_bond_villains]: https://en.wikipedia.org/wiki/List_of_James_Bond_villains
[nicknack]: http://jamesbond.wikia.com/wiki/Nick_Nack