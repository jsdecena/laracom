[![Build Status](https://travis-ci.org/Laracommerce/laracom.svg?branch=master)](https://travis-ci.org/Laracommerce/laracom)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Laracommerce/laracom/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Laracommerce/laracom/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/Laracommerce/laracom/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Test Coverage](https://img.shields.io/codecov/c/github/Laracommerce/laracom/master.svg)](https://codecov.io/github/Laracommerce/laracom?branch=master)
[![Fork Status](https://img.shields.io/github/forks/Laracommerce/laracom.svg)](https://github.com/Laracommerce/laracom)
[![Star Status](https://img.shields.io/github/stars/Laracommerce/laracom.svg)](https://github.com/Laracommerce/laracom)
[![Gitter chat](https://badges.gitter.im/gitterHQ/gitter.png)](https://gitter.im/larac0m/Lobby)

# Laravel FREE E-Commerce Software

- See full [documentation](https://shop.laracom.net/docs)


#1 - Docker approach

If you want to to use this approach first you need to 
copy the file contents 
`.env.docker` to your `.env` file.

In case you want to change the credentials of your 
[MySQL](https://mysql.com) database you need to change the 
[file docker-composer.yml](docker-compose.yml) in **database**
services.

If you wan to execute the repository using [docker](https://docker.com)
you can simple run the command(s):

#### If you want to just run the containers at once:
```docker-compose up```

#### If you want to build the containers:
````docker-compose run --build````

#### If you want to run it in detach mode:
````docker-compose run -d````

#### If you want to run it in detach and build:
````docker-compose run -d --build````

To run PHP artisan commands inside the container context you need to 
run:

```docker-compose run --rm php php artisan <command>```

If you want to run any composer command you run the command:

```docker-compose run --rm composer composer <command>```


#### 1.1 - OPCache

The docker PHP container is using the OPCache for code optimization
and if you want to chance some configuration 
you can change the file [opcache.ini](docker/php/conf.d/opcache.ini) 
inside the of [docker/php/conf.d/ folder](docker/php/conf.d) and 
set up your custom configuration.

### 1.2 Nginx

All the default configurations of nginx you can found on file 
[host.conf](host.conf) and by default you can set up your custom 
configs. By Default the nginx is configured to hold 
SSL certificates, you can configure your own SSL certificates to
work on localhost.

Please visit the [link](https://medium.com/faun/setting-up-ssl-certificates-for-nginx-in-docker-environ-e7eec5ebb418)
 to see how to set up the certificates for yourself.
 
### 1.3 MySQL

The container there's any special configuration, but if you wan to 
access the container terminal to run some command
inside it you can
do in 2 ways.

- ```docker-compose run --rm database <command>```

or 

- ```docker-compose run --rm database /bin/bash```, and it'll
open the terminal context (like a normal linux machine).


### 1.3 Redis

Same logic applied for MySQL container. You can access by commands:

- ```docker-compose run --rm redis <command>```

or 

- ```docker-compose run --rm redis /bin/bash```, and it'll
open the terminal context (like a normal linux machine).



### 1.3 Composer

Same logic applied for MySQL/Redis containers. 
You can access by commands:

- ```docker-compose run --rm composer composer <command>```

or 

- ```docker-compose run --rm composer /bin/bash```, and it'll
open the terminal context (like a normal linux machine).


# Author

[Jeff Simons Decena](https://jsdecena.me)