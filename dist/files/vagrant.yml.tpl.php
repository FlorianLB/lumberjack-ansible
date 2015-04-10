global:

servers:
  <?php echo $general['vm_name']; ?>:
    box: 
      name: 'virtualbox-debian-wheezy-64'
      url: 'https://dl.dropboxusercontent.com/u/10765492/debian-wheezy-64.box'
    hostname: "<?php echo $general['vm_name']; ?>"
    network:
      private: "<?php echo $general['address_ip']; ?>"
    virtualbox:
      name: "<?php echo $general['vm_name']; ?>"
      gui: false
      memory: 1024
    synced_folders:
      vagrant: false
      docroot:
        host_path: '.'
        guest_path: '/home/vagrant/www/project'
        params:
          :type: nfs    
    vbguest:
      auto_update: true
      no_remote: false
    provision:
      ansible:
        :inventory_path: "ansible/dev"
        :playbook: "ansible/app.yml"
        :extra_vars:
          uservar: "vagrant"
        :limit: "all"
        :verbose: "vvvv"