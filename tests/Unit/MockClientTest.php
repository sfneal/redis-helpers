<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Illuminate\Foundation\Application;

class MockClientTest extends UnitTestCase
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

        $app['config']->set('database.redis.client', 'mock');
    }
}
