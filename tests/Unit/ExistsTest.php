<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class ExistsTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider keyValueProvider
     */
    public function key_exists($key, $value)
    {
        $wasSet = RedisCache::set($key, $value);
        $actual = RedisCache::exists($key);

        $this->assertTrue($wasSet);
        $this->assertTrue($actual);
    }

    /**
     * @test
     *
     * @dataProvider keyValueProvider
     */
    public function key_exists_helper($key, $value)
    {
        $wasSet = RedisCache::set($key, $value);
        $actual = redisExists($key);

        $this->assertTrue($wasSet);
        $this->assertTrue($actual);
    }
}
