# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "bento/ubuntu-14.04"
  config.vm.box_check_update = true

  config.vm.network :forwarded_port, guest: 80, host: 8931, auto_correct: true

  config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

   config.vm.synced_folder ".", "/var/www/html/", id: "vagrant-root", :owner => "www-data", :group => "www-data"

  #Provision script - run once
  config.vm.provision "shell", path: "provision.sh"
end
