# Simplified dockerized php application
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fjsdecena%2Fdocker-php-lemp.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fjsdecena%2Fdocker-php-lemp?ref=badge_shield)


## How to Install

- Download and install docker in your system. [Download here](https://www.docker.com/get-started)

- Install composer [here](https://getcomposer.org/doc/00-intro.md) if you haven't

- Clone your app inside the `project` folder. It must have `/public` folder since the webserver looks for the index here

  - A new laravel / lumen application can be installed with:

```php
composer create-project --prefer-dist laravel/laravel .
```

OR

```php
composer create-project --prefer-dist laravel/lumen .
```

- Move to the root folder and run `docker-compose up -d`

- Open your browser and go to [http://localhost:8000](http://localhost:8000)

- Enjoy!

## FAQ

- Why port 81?
  - Sometimes you want your backend and frontend separated. You can have your frontend runs in the default `:80` and the API to be in port `:81`
  
- Can we change this port?
  - Yes. You can change the port in the webserver block of the `docker-compose.yml` file
  
- Is everything customizable?
  - Yes. You can fiddle the `docker-compose.yml` file and make your own customization. Be sure you know what you are doing.
  
  
  
# Author
[Jeff Simons Decena](https://jsdecena.me)

## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fjsdecena%2Fdocker-php-lemp.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fjsdecena%2Fdocker-php-lemp?ref=badge_large)