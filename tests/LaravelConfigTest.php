<?php

namespace Sfneal\Helpers\Redis\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use Sfneal\Helpers\Redis\Providers\RedisHelpersServiceProvider;

class LaravelConfigTest extends TestCase
{
    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array|string
     */
    protected function getPackageProviders($app)
    {
        return RedisHelpersServiceProvider::class;
    }

    /** @test */
    public function config_is_accessible()
    {
        // Confirm the redis-helper config array exists
        $this->assertIsArray(config('redis-helpers'));
    }

    /** @test */
    public function config_prefix()
    {
        // Confirm the default config 'prefix' key is correct
        $output = config('redis-helpers.prefix');
        $expected = 'app';
        $this->assertTrue($output == $expected);
    }

    /** @test */
    public function config_ttl()
    {
        // Confirm the default config 'prefix' key is correct
        $output = config('redis-helpers.ttl');
        $expected = 3600;
        $this->assertIsInt($output);
        $this->assertTrue($output == $expected);
    }
}
