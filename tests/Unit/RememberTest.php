<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class RememberTest extends TestCase
{
    /**
     * @test
     */
    public function remember()
    {
        $key = 'keytoremember';
        RedisCache::remember($key, function () {
            return md5(random_int(1000, 2000));
        }, 100);

        $this->assertTrue(RedisCache::exists($key), "'{$key}' does not exist");
    }

    /**
     * @test
     */
    public function remember_helper()
    {
        $key = 'keytoremember';
        redisRemember($key, function () {
            return md5(random_int(1000, 2000));
        }, 100);

        $this->assertTrue(RedisCache::exists($key), "'{$key}' does not exist");
    }
}
