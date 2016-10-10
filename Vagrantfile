# -*- mode: ruby -*-
# vi: set ft=ruby :

# @see http://stackoverflow.com/a/19507570
unless Vagrant.has_plugin?("vagrant-vbguest")
  raise 'You must install a plugin to keep the Guest Additions up-to-date: vagrant plugin install vagrant-vbguest'
end

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"

  # nginx http + https
  config.vm.network :forwarded_port, guest: 80, host: 8080
  config.vm.network :forwarded_port, guest: 443, host: 4433

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network :private_network, ip: "10.11.12.13"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network :public_network

  # If true, then any SSH connections made will enable agent forwarding.
  # Default value: false
  config.ssh.forward_agent = true

  config.vm.synced_folder "./", "/vagrant/", :type => "nfs", :nfs_version => 4, :nfs_udp => false, :nfs => {
    :mount_options => ["dmode=777, fmode=777"]
  }

  config.vm.provider :virtualbox do |vb|
    # Use VBoxManage to customize the VM. For example to change memory:
    vb.customize ["modifyvm", :id, "--memory", "512"]
  end

  config.vm.provision "ansible" do |ansible|
    ansible.playbook = ".ansible/playbooks/provision.yml"
    ansible.groups = {
      "development" => ["default"]
    }
  end

  config.vm.provision "ansible", run: "always" do |ansible|
    ansible.playbook = ".ansible/playbooks/provision.yml"
    ansible.groups = {
        "development" => ["default"]
    }
    ansible.tags = ["swap"]
  end
end
