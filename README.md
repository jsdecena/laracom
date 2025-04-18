[![Build Status](https://travis-ci.org/jsdecena/laracom.svg?branch=master)](https://travis-ci.org/jsdecena/laracom)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Laracommerce/laracom/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Laracommerce/laracom/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/Laracommerce/laracom/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![codecov](https://codecov.io/gh/jsdecena/laracom/branch/master/graph/badge.svg)](https://codecov.io/gh/jsdecena/laracom)
[![Fork Status](https://img.shields.io/github/forks/jsdecena/laracom.svg)](https://github.com/jsdecena/laracom)
[![Star Status](https://img.shields.io/github/stars/jsdecena/laracom.svg)](https://github.com/jsdecena/laracom)
[![Gitter chat](https://badges.gitter.im/gitterHQ/gitter.png)](https://gitter.im/larac0m/Lobby)
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FLaracommerce%2Flaracom.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2FLaracommerce%2Flaracom?ref=badge_shield)

# Get discount on Digital Ocean

Sign-up with [Digital Ocean and get $10 discount](https://m.do.co/c/bce94237de96)!

# Laravel FREE E-Commerce Software

Features Provided

-   Products
-   Cart
-   Checkout
-   Categories
-   Customers
-   Orders
-   Payment
-   Couriers
-   Employees

-   To view more details of the features
    See full [documentation](https://jsdecena.github.io/laracom)

# Simplified DOCKER setup

## In your teminal, issue these commands

-   RUN `docker-compose up -d --build`
-   If your runtime is apple silicon, use `docker-compose -f docker-compose-m1.yml up -d --build` command
-   RUN `docker exec -it app bash`
-   Inside the container, run `composer install && chmod -R 777 storage/ bootstrap/cache/`
-   Inside the container, run `php artisan migrate --seed`
-   While inside the container, compile the assets with `npm i && npm run dev`
-   While inside the container, link the images `php artisan storage:link`
-   OPEN [http://localhost:8000](http://localhost:8000)

## If you want to use mailhog as SMTP

1.Create a ./mails directory
2.change .env like this

```
MAIL_DRIVER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="test@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

3.Go to http://localhost:8025 and verify that the mailhog screen appears

# Author

[Jeff Simons Decena](https://jsdecena.me)

# Contributors

<a href="https://github.com/jsdecena/laracom/graphs/contributors"><img src="https://opencollective.com/laracom/contributors.svg?width=890" title="contributors" alt="contributors" /></a>

## License

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FLaracommerce%2Flaracom.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2FLaracommerce%2Flaracom?ref=badge_large)
