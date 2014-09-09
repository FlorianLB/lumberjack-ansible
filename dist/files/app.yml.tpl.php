# http://docs.ansible.com/playbooks.html

---

- name: apply common configuration to all nodes
  hosts: all
  vars_files:
<?php if (isset($rolesToInstall['elasticsearch'])) : ?>
    - roles/elasticsearch/vars/vagrant.yml
<?php endif; ?>
    - settings.yml
  remote_user: "{{ uservar }}"
  sudo: true
  sudo_user: root
  roles:
<?php foreach ($rolesToInstall as $role => $value) : ?>
    - <?php echo $role."\n"; ?>
<?php endforeach; ?>
