## Requirements

* [Vagrant](https://www.vagrantup.com/downloads.html) (version >= 1.6)
* [Ansible](https://github.com/ansible/ansible) (version >= 1.8)

## Your box

The downloaded archive is composed of 3 main elements:

* a `Vagrantfile`
* a folder called `ansible` that contains all provisionning files
* That README.md

## How to use your Box?

* `vagrant up`
* Wait provisioning end (can take a while)
* Go to `http://[HOSTNAME]:1000`, you will see a dashboard that list tools related to components installed on the virtual machine.
