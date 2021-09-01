<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class GetTest extends TestCase
{
    /**
     * @test
     * @dataProvider keyValueProvider
     */
    public function get_keys_value($key, $value)
    {
        RedisCache::set($key, $value);
        $output = RedisCache::get($key);

        $this->assertEquals($value, $output);
    }

    /**
     * @test
     * @dataProvider keyValueProvider
     */
    public function get_keys_value_helper($key, $value)
    {
        RedisCache::set($key, $value);
        $output = redisGet($key);

        $this->assertEquals($value, $output);
    }
}
