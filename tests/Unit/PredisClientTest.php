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
        $app['config']->set('database.redis.default.host', 'cache');
        $app['config']->set('database.redis.default.password', null);
        $app['config']->set('database.redis.default.port', 6379);
        $app['config']->set('database.redis.default.database', 0);
        $app['config']->set('cache.stores.redis.connection', 'default');
    }
}
