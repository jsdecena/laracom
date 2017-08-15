[![Build Status](https://travis-ci.org/jsdecena/laracom.svg?branch=master)](https://travis-ci.org/jsdecena/laracom)

### Laravel E-Commerce Application

### Framework Used : Laravel 5.4

### Development environment : [Homestead](https://laravel.com/docs/5.3/homestead)

### Requirements

- [VirtualBox](https://www.virtualbox.org/wiki/Downloads)

- [Vagrant](https://www.vagrantup.com/downloads.html)

- [Composer](https://getcomposer.org/download/)

** Notes: Turn on VT-x in your machine: **

- [Windows](http://www.howtogeek.com/213795/how-to-enable-intel-vt-x-in-your-computers-bios-or-uefi-firmware/)

- [Linux](http://askubuntu.com/questions/256792/how-do-i-enable-hardware-virtualization-technology-vt-x-for-use-in-virtualbox)

### Installation Globally

- Open you terminal and run `vagrant box add laravel/homestead`

- Type `cd ~ && git clone https://github.com/laravel/homestead.git Homestead`

- Go to `~/Homestead` and run `bash init.sh` for unix/linux and `init.bat` for windows

- Then run `vagrant up --provision`

- Wait until the provisioning is finished then you can go to [http://192.168.10.10](http://192.168.10.10)

- **OPTIONAL** You can also set the IP and name to `/etc/hosts` like this `192.168.10.10 homestead.app` so you can go to [http://homestead.app](http://homestead.app)