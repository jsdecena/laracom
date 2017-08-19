[![Build Status](https://travis-ci.org/jsdecena/laracom.svg?branch=master)](https://travis-ci.org/jsdecena/laracom) [![Coverage Status](https://coveralls.io/repos/github/jsdecena/laracom/badge.svg?branch=master)](https://coveralls.io/github/jsdecena/laracom?branch=master) [![Total Downloads](https://poser.pugx.org/jsdecena/laracom/downloads)](https://packagist.org/packages/jsdecena/laracom) [![License](https://poser.pugx.org/jsdecena/laracom/license)](https://packagist.org/packages/jsdecena/laracom) [![Latest Stable Version](https://poser.pugx.org/jsdecena/laracom/version)](https://packagist.org/packages/jsdecena/laracom)

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

- Create the project with `cd ~ && composer create-project jsdecena/laracom`

- Modify your `Homestead.yml` file in `~/.homestead` folder with

```
folders:
    - map: ~/Code
      to: /home/vagrant/Code

sites:
    - map: homestead.app
      to: /home/vagrant/Code/laracom/public
```

Just make sure you have `Code` folder in your home directory. If you have other workspace folder, change the Code with your folder.

- Then run `vagrant up --provision`

- Wait until the provisioning is finished then you can go to [http://192.168.10.10](http://192.168.10.10)

- **OPTIONAL** You can also set the IP and name to `/etc/hosts` like this `192.168.10.10 homestead.app` so you can go to [http://homestead.app](http://homestead.app)