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
- add test methods for untested methods
- cut use of 'prefix' config key & RedisCache::key() method


## 1.1.1 - 2021-02-01
- fix return type hinting in redisFlush() helper function


## 1.2.0 - 2021-02-02
- add call to RedisCache::flush() in TestCase::tearDown() to clear any previously cached values
- add RedisCache::keys() method that lists keys in the Redis cache
- add ability to delete nested keys to RedisCache::delete() method
- add ttl() method to RedisCache for checking the time to live of a particular key
- add josiasmontag/laravel-redis-mock to composer dev requirements for creating a better Redis conenction mock


## 1.2.1 - 2021-02-02
- add ability to specify weather to delete children when deleting a parent key


## 1.2.2 - 2021-03-30
- fix sfneal/actions version syntax
- fix Travis CI config to enable code coverage uploads


## 1.3.0 - 2021-03-31
- cut sfneal/actions composer requirement


## 1.3.1 - 2021-04-28
- cut sfneal/actions composer requirement
- add conditional to `keyWithPrefix()` to prevent adding a prefix when none is set
- optimize type hinting


## 1.3.2 - 2021-07-12
- refactor test suite into `Feature` & `Unit` namespaces


## 1.3.3 - 2021-08-26
- add support for running test suite using predis/predis client
- refactor Unit tests into traits used by each client test that separate tests by action (Delete, Exists, Get, Set, etc)
- add support for building Docker images and running a docker-compose services that run the test suite using predis/predis connected to a real redis server (opposed to a mock)


## 1.3.4 - 2021-08-26
- optimize composer scripts
- add improved assertions to 'delete' & 'exists' test traits


## 1.3.5 - 2021-08-26
- cut laravel/framework dependency & replaced with illuminate/support
- add `NestedKeysTest` to unit test traits so that it can be tested using 'mock' & 'predis' clients


## 1.4.0 - 2021-08-30
- optimize test suite organization by setting redis client & other config values in the root `TestCase` #26
- fix issues with nested keys tests failing while using the 'mock' redis client #27
- add try/catch block to `RedisCache::key()` method so that when an error is encountered while trying to find child keys, the original key is returned


## 1.4.1 - 2021-09-01
- add helper method tests & use of DataProviders
- optimize methods return type hinting


## 2.0.0 - 2021-09-01
- cut `redisCreateIfMissing()` helper function
- cut `flush()` method as it provided no further functionality over `Cache::flush()`
- cut `rememberForever()` method
- refactor param declaration order of `remember()` method so that $ttl is nullable and uses the default


# 2.0.1 - 2021-09-14
- add composer scripts for running all docker version tests
- cut down.sh & moved contents to composer script
- add use of git cli for getting username & repo name


# 2.0.2 - 2024-04-16
- add GitHub action for running CI


# 3.0.0 - 2024-04-16
- cut support for PHP 7
- add support for PHP 8.1, 8.2 & 8.3
