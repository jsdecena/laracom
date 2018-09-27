# Installation

Laracome is the project base on Laravel application, so everything are the same with Laravel base project.

---

- [Requirements](#requirements)
- [Admin Credentials](#admin-credentials)
- [Buils and compile](#build-compile)
- [Native PHP Server](#native-php-server)
- [Configure Laracom](#configure-laracom)

<a name="Requirements"></a>
### Requirements

  - PHP 7.1 or higher 
  - Laravel 5.6 or higher

> {primary} Sign-up with [DigitalOcean](https://m.do.co/c/bce94237de96) and get $10 discount! Create a droplet with LEMP stack config


##### Install on Vagrant

Add Homestead Vagrant box (Make sure you already install Vagrant)

```php
vagrant box add laravel/homestead
```

Then clone Laravel homestead from laravel github

```php
git clone https://github.com/laravel/homestead.git Homestead
```
Then just follow these step 

```php
cd Homestead // to your homestead path
bash init.sh // for Unix/Linux
init.bat     // for Windows
```
Create the project with 

```php
composer create-project jsdecena/laracom
```

Modify your `Homestead.yml` file in `~/.homestead` folder with

```yaml
folders:
    - map: ~/Code
      to: /home/vagrant/Code

sites:
    - map: homestead.app
      to: /home/vagrant/Code/laracom/public
```

Just make sure you have `Code` folder in your home directory. If you have other workspace folders, change the Code with your folder. Then run 

```yaml 
vagrant up --provision
```

- Wait until the provisioning is finished then you can go to [http://192.168.10.10](http://192.168.10.10)

> **OPTIONAL** You can also set the IP and name to `/etc/hosts` like this `192.168.10.10 homestead.app` so you can go to [http://homestead.app](http://homestead.app)

### Native PHP server

If you prefer using `php artisan` command, You just need to run 

```php
php php artisan serve
```` 

and it will open a browser for you

<a name="build-compile"></a>
### Buils and compile assets

If you haven't install node, [install it now](https://github.com/creationix/nvm#install-script)

Install all dependecies from package.json

```nodejs
npm install
```

Then you can compile your assets (currently, only admin assets are being compiled)

```nodesjs
npm run dev
```

### How to configure Laracom

Go to Homestead directory via the terminal: 

```bash
cd ~/Homestead
vagrant ssh
```

Once inside vagrant, cd to your project folder: 

```bash 
cd ~/Homestead/Code/<project folder>
composer install
```
Copy **.env.example**  `cp .env.example .env`

If you are on `homestead`, default details DB connections are: 

```php
DB_CONNECTION=mysql
DB_HOST=192.168.10.10
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

Run migration and seed default data with 

```php 
php artisan migrate --seed
```

Symlink the `storage` folder to public. Run 

```php
php artisan storage:link
``` 

**This is important to display the uploaded images**

If you run your app with `php artisan serve` connect to your installed db connection

## Other settings

By default, Paypal (Express Checkout) is the default payment gateway. You must configure the credentials in the payment methods admin:

```php
Account ID = xxxxx-facilitator@email.com
Client ID = xxxx
Client Secret = xxxx
Payment URL = https://api.sandbox.paypal.com
Mode = sandbox or live
```

MailChimp Newsletter settings should be set in `.env`

```php
MAILCHIMP_API_KEY=
MAILCHIMP_LIST_ID=
```

Set your mail server in the `.env`

```php
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
```

Set your shop default config

```php
SHIPPING_COST=0
TAX_RATE=10
DEFAULT_CURRENCY=USD
```

<a name="admin-credentials"></a>
### Admin dashboard login credentials:

!!! Email and Passwords !!!

```php
john@doe.com / secret (role:superadmin)
admin@doe.com / secret (role:admin)
clerk@doe.com / secret (role:user)
```