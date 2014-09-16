# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "virtualbox-debian-wheezy-64"

  # Debian Wheezy 7.0 amd64 - Vanilla
  config.vm.box_url = "https://dl.dropboxusercontent.com/u/10765492/debian-wheezy-64.box"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.

  # IP Address of the VM
  config.vm.network "private_network", ip: "<?php echo $general['address_ip']; ?>"

  # Hostname of the VM (use in ansible inventory : ansible/dev)
  config.vm.hostname = "<?php echo $general['vm_name']; ?>"

  # Deactivation of the default share
  config.vm.synced_folder ".", "/vagrant", id: "vagrant-root", disabled: true

  # Share of the current folder
  config.vm.synced_folder ".", "/home/vagrant/www/project", type: "nfs"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  config.vm.provider "virtualbox" do |vb|
     # Don't boot with headless mode
     vb.gui = false

     # Use VBoxManage to customize the VM. For example to change memory:
     vb.customize ["modifyvm", :id, "--memory", "1024"]
   end


  # Provisioning Ansible
  #  * http://docs.vagrantup.com/v2/provisioning/ansible.html
  #  * http://docs.ansible.com/guide_vagrant.html
  config.vm.provision "ansible" do |ansible|
    ansible.inventory_path = "ansible/dev"
    ansible.playbook = "ansible/app.yml"
    ansible.extra_vars = {
      uservar: "vagrant"
    }
    ansible.limit= "all"
    ansible.verbose = "vvvv"
  end


  # PLUGINS

  config.vbguest.auto_update = true
  config.vbguest.no_remote = false

end
