<?php

namespace Sfneal\Helpers\Redis\Tests\Unit\Traits;

use Sfneal\Helpers\Redis\RedisCache;

trait TtlTest
{
    /**
     * @test
     */
    public function default_ttl()
    {
        $key = 'bos:52:pos';
        RedisCache::set($key, 'c');
        $ttl = RedisCache::ttl($key);

        $this->assertIsInt($ttl);
        $this->assertEquals(config('redis-helpers.ttl'), $ttl);
    }

    /**
     * @test
     */
    public function expire_key()
    {
        $key = 'heresanotherkey';
        $ttl = 100;
        RedisCache::set($key, 'value');
        $stored = RedisCache::expire($key, $ttl);

        $this->assertEquals($ttl, RedisCache::ttl($key));
        $this->assertTrue($stored);
    }
}
