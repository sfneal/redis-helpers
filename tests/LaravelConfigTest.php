<?php

namespace Sfneal\Helpers\Redis\Tests;

class LaravelConfigTest extends TestCase
{
    /** @test */
    public function config_is_accessible()
    {
        // Confirm the redis-helper config array exists
        $this->assertIsArray(config('redis-helpers'));
    }

    /** @test */
    public function config_ttl()
    {
        // Confirm the default config 'prefix' key is correct
        $output = config('redis-helpers.ttl');
        $expected = 3600;
        $this->assertIsInt($output);
        $this->assertSame($expected, $output);
    }
}
