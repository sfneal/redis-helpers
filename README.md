# Redis Helpers

[![Packagist PHP support](https://img.shields.io/packagist/php-v/sfneal/redis-helpers)](https://packagist.org/packages/sfneal/redis-helpers)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sfneal/redis-helpers.svg?style=flat-square)](https://packagist.org/packages/sfneal/redis-helpers)
[![Build Status](https://travis-ci.com/sfneal/redis-helpers.svg?branch=master&style=flat-square)](https://travis-ci.com/sfneal/redis-helpers)
[![StyleCI](https://github.styleci.io/repos/288488301/shield?branch=master)](https://github.styleci.io/repos/288488301?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sfneal/redis-helpers/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sfneal/redis-helpers/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/sfneal/redis-helpers.svg?style=flat-square)](https://packagist.org/packages/sfneal/redis-helpers)

Redis helper functions for improved Redis cache transactions with PHP applications



## Installation

You can install the package via composer:

```bash
composer require sfneal/redis-helpers
```

In order to autoload to the helper functions add the following path to the autoload.files section in your composer.json.

```json
"autoload": {
    "files": [
        "vendor/sfneal/redis-helpers/src/redis.php"
    ]
},
```

To modify the redis-helpers 'prefix' & 'ttl' setting publish the ServiceProvider & modify the config.

``` php
php artisan vendor:publish --provider="Sfneal\Helpers\Redis\Providers\RedisHelpersServiceProvider"
```

## Usage

``` php
# Add a key value pair to the cache
RedisCache::set('pastrnak', 88);
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email stephen.neal14@gmail.com instead of using the issue tracker.

## Credits

- [Stephen Neal](https://github.com/sfneal)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
