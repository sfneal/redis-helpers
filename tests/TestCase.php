<?php

namespace Sfneal\Helpers\Redis\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Lunaweb\RedisMock\Providers\RedisMockServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sfneal\Helpers\Redis\Providers\RedisHelpersServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        // make sure, our .env file is loaded
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        $app['config']->set('app.debug', true);
        $app['config']->set('cache.default', 'redis');
        $app['config']->set('cache.prefix', 'redis-helpers');

        $app['config']->set('database.redis.client', env('REDIS_CLIENT', 'mock'));
        $app['config']->set('database.redis.default.host', env('REDIS_HOST', '127.0.0.1'));
        $app['config']->set('database.redis.default.port', env('REDIS_PORT', 6379));
        $app['config']->set('database.redis.default.options.prefix', null);
        $app['config']->set('cache.stores.redis.connection', 'default');
    }

    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            RedisHelpersServiceProvider::class,
            RedisMockServiceProvider::class,
        ];
    }
}
