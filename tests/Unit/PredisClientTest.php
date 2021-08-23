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
        $app['config']->set('database.redis.predis', [
            'host'     => 'cache',
            'password' => null,
            'port'     => 6379,
            'database' => 0,
        ]);
        $app['config']->set('cache.stores.redis.connection', 'predis');
    }
}
