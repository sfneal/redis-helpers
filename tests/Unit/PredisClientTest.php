<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Illuminate\Foundation\Application;
use Sfneal\Helpers\Redis\Tests\UnitTestCase;

class PredisClientTest extends UnitTestCase
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

        $app['config']->set('database.redis.client', 'predis');
        $app['config']->set('database.redis.default.host', env('REDIS_HOST', '127.0.0.1'));
        $app['config']->set('database.redis.default.options.prefix', null);
        $app['config']->set('cache.stores.redis.connection', 'default');
    }
}
