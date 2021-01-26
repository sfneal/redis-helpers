# Changelog

All notable changes to `redis-helpers` will be documented in this file

## 0.1.0 - 2020-08-18
- initial release


## 0.1.1 - 2020-08-20
- add redisRemember & redisRememberForever helper functions


## 0.2.0 - 2020-08-20
- make RedisCache service with public methods that serve as the back-end for helper functions


## 0.2.1 - 2020-08-21
- fix issue with RedisCache::keys() type hinting


## 0.3.0 - 2020-09-08
- fix composer.json to allow for use of laravel/framework:8.0


## 0.4.0 - 2020-10-07
- add backwards compatibility for php7


## 0.5.0 - 2020-10-08
- add support for php8


## 0.5.1 - 2020-12-11
- fix support for php8


## 0.6.0 - 2021-01-21
- add config file & service provider for publishing & registering it
- fix use of env() helper function with config() in RedisCache
- add service provider to composer.json for publishing config file
- cut autoloading of helpers.php


## 0.7.0 - 2021-01-21
- cut support for php7.0
- add LaravelTest for testing ServiceProvider & config


## 0.7.1 - 2021-01-22
- fix min laravel/framework version to support php7.1


## 0.7.2 - 2021-01-22
- fix min orchestra/testbench version to support php7.1


## 0.8.0 - 2021-01-25
- fix issue with self::key() method not being used in set() method
- add setMany method to RedisCache for setting an array of key values
- add RedisCacheTest for testing RedisCache functionality


## 0.8.1 - 2021-01-26
- add laravel/framework back into composer requirements
- fix RedisCache::delete() & RedisCache::keys() methods (as well as helper functions)
- optimize type hinting
- fix issue with use of Redis::connection() method


## 1.0.0 - 2021-01-26
- add type hinting to RedisCache::flush & redisFlush
- initial production release


## 1.1.0 - 2021-01-26
- cut use of 'prefix' config key & RedisCache::key() method
- add test methods for untested methods
