# Installation

Laracom is based on Laravel application, so everything are the same with Laravel base project.

> {success} Sign-up with [Digital Ocean](https://m.do.co/c/bce94237de96) and get **$10** discount!

---

- [Requirements](#requirements)
- [Native PHP Server](#native-php-server)
- [Build and compile](#build-compile)
- [Configure Laracom](#configure-laracom)
- [Other Settings](#other-setting)
- [Admin Dashboard](#admin-dashboard)
- [Production installation](#production-installation)

<a name="requirements"></a>

### Requirements

  - PHP 7.1 or higher 
  - Laravel 5.6 or higher
  - Composer

> {info} There are many ways to install a Laravel app but we suggest using **Homestead**.

#### Homestead

Install [Laravel Homestead](https://laravel.com/docs/5.7/homestead#installation-and-setup). Just follow the instruction on the site.

> {primary} Protip: Create your own folder in your home directory like `Code` to segregate your coding projects

Go to your preferred workspace location and create the project with 

```php
composer create-project jsdecena/laracom
```

Modify your `Homestead.yml` file in `~/.homestead` folder with

```yaml
folders:
    - map: ~/Code
      to: /home/vagrant/Code

sites:
    - map: laracom.app
      to: /home/vagrant/Code/laracom/public
```

Just make sure you have `Code` folder in your home directory. If you have other workspace folders, change the `Code` with your folder. Then run 

```yaml 
vagrant up --provision
```

- Wait until the provisioning is finished then you can go to [http://192.168.10.10](http://192.168.10.10)

> {primary} Protip: You can also set the IP and name to `/etc/hosts` like this `192.168.10.10 laracom.app` so you can go to [http://laracom.app](http://laracom.app)

<a name="native-php-server"></a>
### Native PHP server

If you prefer using `php artisan` command, You just need to run 

```php
php php artisan serve
```` 

and it will open a browser for you

<a name="build-compile"></a>

### Build and compile assets

Install [NVM (Node Version Manager)](https://github.com/creationix/nvm#install-script)

Install all dependencies and compile admin and frontend css / javascripts

```nodejs
npm install && npm run dev
```

> {primary} Protip: If you are adjusting your own theme for the frontend, you need to adjust the webpack.mix.js so it will compile your assets

```js
    ....
    .styles(
        [
            'node_modules/bootstrap/dist/css/bootstrap.css',
            'node_modules/font-awesome/css/font-awesome.css',
            'node_modules/select2/dist/css/select2.css',
            'resources/assets/css/drift-basic.min.css',
            'resources/assets/css/front.css'
        ],
        'public/css/style.min.css'
    )
    .scripts(
        [
            'node_modules/bootstrap/dist/js/bootstrap.js',
            'node_modules/select2/dist/js/select2.js',
            'resources/assets/js/owl.carousel.min.js',
            'resources/assets/js/Drift.min.js'
        ],
        'public/js/front.min.js'
    )
    .copyDirectory('node_modules/datatables/media/images', 'public/images')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
    .copyDirectory('resources/assets/admin-lte/img', 'public/img')
    .copyDirectory('resources/assets/images', 'public/images')
    .copy('resources/assets/js/scripts.js', 'public/js/scripts.js')
    .copy('resources/assets/js/custom.js', 'public/js/custom.js');    
```

then run again: `npm run dev` to install your changes. 

The public folder will have single `style.min.css` and `front.min.js` for all your assets. You can also copy files to the public folder.

<a name="configure-laracom"></a>
### How to configure Laracom

Go to Homestead directory via the terminal: 

```bash
cd ~/Homestead
vagrant ssh
```

Once inside vagrant, cd to your project folder: 

```bash 
cd ~/Homestead/Code/laracom
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

> {primary} Issuing the `php artisan storage:link` is **IMPORTANT** to display all the images

If you run your app with `php artisan serve` connect to your installed db connection

<a name="other-setting"></a>
### Other settings

By default, Paypal (Express Checkout) is the default payment gateway. You must configure the credentials in the payment methods admin:

```php
PP_ACCOUNT_ID=xxxxx-facilitator@email.com
PP_CLIENT_ID=xxxxxx
PP_CLIENT_SECRET=xxxx
PP_API_URL=https://api.sandbox.paypal.com
PP_REDIRECT_URL=http://localhost/execute
PP_CANCEL_URL=http://localhost/cancel
PP_FAILED_URL=http://localhost/failed
PP_MODE=sandbox
```

You can enable / disable the payment gateways via the .env.

```php
PAYMENT_METHODS=paypal,stripe,bank-transfer
```

Stripe

```php
STRIPE_KEY=xxxx
STRIPE_SECRET=xxxx
STRIPE_REDIRECT_URL=http://localhost/execute?stripe
STRIPE_CANCEL_URL=http://localhost/cancel?stripe
STRIPE_FAILED_URL=http://localhost/failed?stripe
```

Bank Transfer

```php
BANK_TRANSFER_NAME=xxxx
BANK_TRANSFER_ACCOUNT_TYPE=xxxx
BANK_TRANSFER_ACCOUNT_NAME=xxxx
BANK_TRANSFER_ACCOUNT_NUMBER=xxx
BANK_TRANSFER_SWIFT_CODE=xxx
BANK_TRANSFER_SWIFT_NOTE=xxx
```

Shop settings

```php
SHOP_NAME=
SHOP_COUNTRY_ISO=
SHOP_COUNTRY_ID=
# options - gms, kgs, oz, lbs
SHOP_WEIGHT=lbs
SHOP_EMAIL=your@email.com
SHIPPING_COST=0
TAX_RATE=10
DEFAULT_CURRENCY=USD
```

You can activate [SHIPPO shipping](https://goshippo.com/) if you need it else set `0` to deactivate

```php
ACTIVATE_SHIPPING=0
SHIPPING_API_TOKEN=shippo_test_xxxxxx
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

<a name="admin-dashboard"></a>
### Admin dashboard
In order to enter the administration dashboard, you have to hit the `/admin` route. 
E.g enter http://localhost/admin or in general http://your-domain/admin in your browser.

If you're not already logged in, you are redirected to the admin login screen.
There you can use one of the following credentials to access the admin dashboard.

**Email and Passwords**

```php
john@doe.com / secret (role:superadmin)
admin@doe.com / secret (role:admin)
clerk@doe.com / secret (role:user)
```

<a name="production-installation"></a>
### Production installation

There are many ways to install it on your server. If you need help, you can message me for *my service*. Thanks!

That should be it! 🎉  If anything else for clarification, you can email ✉️  or message me. 😄 

If you find this app useful, with a kind heart, consider a [donation](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=KAKJ8ZTEC6YY6&lc=US&item_name=jsdecena%2flaracom&no_note=0&cn=Add%20special%20instructions%20to%20the%20seller%3a&no_shipping=1&rm=1&return=https%3a%2f%2flaracom%2enet%2f&cancel_return=https%3a%2f%2flaracom%2enet%2f&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted) or by me a [coffee](https://ko-fi.com/G2G0ADEK)
