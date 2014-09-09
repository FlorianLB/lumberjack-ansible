# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "virtualbox-debian-wheezy-64"

  # URL auquel télécharger la basebox si non disponible sur la machine hôte
  # Debian Wheezy 7.0 amd64 - Vanilla
  config.vm.box_url = "http://home.clever-age.net/~jkruppa/debian-wheezy-64.box"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.

  # Adresse IP de la VM
  config.vm.network "private_network", ip: "<?php echo $general['address_ip']; ?>"

  # Nom d'hôte de la VM (utilisé dans l'inventaire de la conf Ansible ansible/dev)
  config.vm.hostname = "<?php echo $general['vm_name']; ?>"

  # Désactivation du partage par défaut
  config.vm.synced_folder ".", "/vagrant", id: "vagrant-root", disabled: true

  # Partage du dossier courant dans la home de l'utilisateur vagrant
  config.vm.synced_folder ".", "/home/vagrant/www/project", type: "nfs"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
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

  # Vérification et mise à jour si nécessaire des guest additions Virtualbox
  # au démarrage de la VM
  config.vbguest.auto_update = true

  # On autorise le plugin vagrant-vbguest à télécharger un ISO des guest additions
  # sur un serveur distant
  config.vbguest.no_remote = false

end
