### FirstTwelve E-Commerce Application

### Framework Used : Laravel 5.3

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

- Edit the `Homestead.yml` file in `~/.homestead` directory

- Change the value in **Homestead.yml** file for the `sites` key with `firstwelve.dev` ( by default it is `homestead.app` )

- Then run `vagrant up --provision`

- Wait until the provisioning is finished then you can go to [http://192.168.10.10](http://192.168.10.10)

- **OPTIONAL** You can also set the IP and name to `/etc/hosts` like this `192.168.10.10 firstwelve.dev` so you can go to [http://firstwelve.dev](http://firstwelve.dev)

### Deployment

- Run in the terminal `envoy run deploy --branch=develop` for deployment in development server or
- Run in the terminal `envoy run deploy --branch=master` for deployment in production server